<template>
  <Draggable
    v-model="playlists"
    v-bind="dragOptions"
    handle=".drag"
    tag="div"
    @update="sort">
    <TransitionGroup
      class="row"
      name="flip-list"
      tag="div"
      type="transition">
      <div v-for="playlist in playlists"
           :key="playlist.id"
           class="col-md-4">
        <Playlist v-bind="playlist"/>
      </div>
    </TransitionGroup>
  </Draggable>
</template>

<script>
import Draggable from 'vuedraggable'
import Playlist from './Playlist'

export default {
  components: {
    Draggable,
    Playlist
  },
  props: {
    orderName: String
  },
  data() {
    return {
      playlists: this.shared('playlists'),

      orderNameLs: `playlists_${this.orderName}_order`,
      dragOptions: {
        animation: 200
      },
    }
  },
  methods: {
    sort() {
      const order = this.playlists.map(({id}) => id)
      this.$ls.set(this.orderNameLs, order)
    },
  },
  created() {
    const order = this.$ls.get(this.orderNameLs)
    if (order !== null && order.length) {
      this.playlists = this.playlists.sort((a, b) => order.indexOf(a.id) - order.indexOf(b.id))
    }
  }
}
</script>
