<template>
  <BOverlay
    :opacity="0.9"
    :show="isLoading"
    variant="white">
    <Draggable
      v-model="channels"
      v-bind="dragOptions"
      :disabled="disabled"
      handle=".drag"
      tag="div"
      @update="sort">
      <TransitionGroup
        class="rss-lists row justify-content-center"
        name="flip-list"
        tag="div"
        type="transition">
        <div v-for="(channel,i) in channels"
             :key="channel.id"
             class="col-xl-3 col-lg-4 col-sm-6 drag">
          <Channel
            v-bind="channel"
            :first="i===0"/>
        </div>
      </TransitionGroup>
    </Draggable>
    <div v-if="page<lastPage" class="text-center">
      <button class="btn btn-cyan"
              @click="load">
        Load more
        <span v-if="isLoading" class="spinner-border spinner-border-sm ml-2"/>
      </button>
    </div>
  </BOverlay>
</template>

<script>
import {BOverlay} from 'bootstrap-vue'
import Draggable from 'vuedraggable'
import Channel from './Channel'

export default {
  components: {
    BOverlay,
    Draggable,
    Channel
  },
  props: {
    withPagination: false,
    sharedKey: {
      type: String,
      default: 'channels'
    },
    orderName: String
  },
  data() {
    const shared = this.shared(this.sharedKey)
    return {
      channels: this.withPagination ? [...shared.data] : [...shared],
      dragOptions: {
        animation: 200
      },
      orderNameLs: `channels_${this.orderName}_order`,
      disabled: this.withPagination || window.innerWidth < 768,

      page: 1,
      lastPage: this.withPagination ? shared.last_page : 1,
      isLoading: false
    }
  },
  created() {
    const order = this.$ls.get(this.orderNameLs)
    if (order !== null && order.length) {
      this.channels = this.channels.sort((a, b) => order.indexOf(a.id) - order.indexOf(b.id))
    }
  },
  methods: {
    sort() {
      const order = this.channels.map(({id}) => id)
      this.$ls.set(this.orderNameLs, order)
    },
    async load() {
      this.isLoading = true
      this.page += 1
      try {
        const response = await this.axios.get(`?page=${this.page}`)
        this.channels = [...this.channels, ...response.data.data]
      } catch (e) {
        console.log(e)
      }
      setTimeout(() => {
        this.isLoading = false
      }, 100)

    }
  }
}
</script>
