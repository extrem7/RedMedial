<template>
  <div>
    <button
      class="btn btn-cyan sidebar__btn"
      @click="$emit('close')"
    >
      Close
    </button>
    <div class="sidebar__inner">
      <ul class="sidebar__menu sidebar-menu">
        <li
          v-for="{name,route:routeName} in links"
          class="sidebar-menu__item"
        >
          <InertiaLink
            :class="{
              'sidebar-menu__link--active': currentRoute===routeName
            }"
            :href="route(routeName)"
            class="sidebar-menu__link"
          >
            {{ name }}
          </InertiaLink>
        </li>
        <li class="sidebar-menu__item">
          <a
            class="sidebar-menu__link sidebar-menu__link--logout"
            href=""
            @click.prevent="logout"
          >
            <SvgVue
              class="sidebar-menu__icon"
              icon="sign"
            />
            Sign out
          </a>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import {useLogout} from '~/use'

export default {
  setup() {
    const {logout} = useLogout()
    return {logout}
  },
  data() {
    return {
      links: [
        {
          name: 'Profile',
          route: 'account.settings.edit'
        },
        {
          name: 'Media',
          route: 'account.media.edit'
        },
        {
          name: 'Rss categories room',
          route: 'account.rss'
        },
        {
          name: 'Customized news iframe',
          route: 'account.iframe'
        },
      ]
    }
  },
  computed: {
    currentRoute() {
      return this.$page.props.route
    }
  }
}
</script>
