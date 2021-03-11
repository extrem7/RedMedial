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
        <li class="sidebar-menu__item">
          <a
            :href="route('account.dashboard')"
            class="sidebar-menu__link sidebar-menu__link--active"
          >
            Profile
          </a>
        </li>
        <li class="sidebar-menu__item">
          <a class="sidebar-menu__link" href="">media</a>
        </li>
        <li class="sidebar-menu__item">
          <a class="sidebar-menu__link" href="">rss categories room</a>
        </li>
        <li class="sidebar-menu__item">
          <a class="sidebar-menu__link" href="">Customized Iframe RSS</a>
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
  }
}
</script>
