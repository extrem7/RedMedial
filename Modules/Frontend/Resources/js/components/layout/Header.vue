<template>
  <header
    class="header"
    :class="{'sticky-header': isScroll}"
  >
    <div class="header-top after-fade">
      <ul class="full-width-menu overflow-horizontal">
        <li
          v-for="(name,slug) in countries"
          class="menu-item"
        >
          <a :href="route('rss.countries.show',slug)">{{ name }}</a>
        </li>
      </ul>
    </div>
    <div class="header-middle container">
      <a class="logo" href="/">
        <img alt="logo" src="/dist/img/logo.svg">
      </a>
      <div>
        <LanguageSwitcher/>
      </div>
      <div :class="{'open-search' : openSearch}"
           class="search-box">
        <form
          :action="route('search')"
          class="search-box-form"
        >
          <input class="form-control" name="query" placeholder="Search" required type="text">
          <button class="btn-submit-search icon" type="submit">
            <SvgVue icon="search"/>
          </button>
          <span
            class="icon close-icon"
            @click="openSearch = !openSearch"
          >
            <SvgVue icon="times"/>
          </span>
        </form>
      </div>
      <button
        class="btn-search icon"
        @click="openSearch = !openSearch"
      >
        <SvgVue icon="search"/>
      </button>
      <a
        v-if="!user"
        :href="route('login')"
        class="header__sign-link"
      >
        <SvgVue
          class="header__sign-icon"
          icon="sign"
        />
        <span class="header__sign--text">Sign In</span>
      </a>
      <BDropdown
        v-else
        id="profile-dropdown"
        class="dropdown-account header__dropdown"
        right
        variant="outline">
        <template #button-content>
          <div class="dropdown-account__profile">
            <img
              :src="user.logo||'/dist/img/ava-default.svg'"
              alt="logo"
              class="dropdown-account__img"
            >
            <span class="dropdown-account__name line-nowrap">{{ user.name }}</span>
          </div>
        </template>
        <BDropdownItem :href="route('account.settings.edit')">
          Profile
        </BDropdownItem>
        <BDropdownItem :href="route('account.media.edit')">
          Media
        </BDropdownItem>
        <BDropdownItem :href="route('account.rss')">
          Rss categories room
        </BDropdownItem>
        <BDropdownItem :href="route('account.iframe')">
          Customized news iframe
        </BDropdownItem>
        <BDropdownItem
          class="dropdown-account__item-logout"
          @click="logout"
        >
          <SvgVue class="dropdown-account__icon" icon="sign"/>
          Sign out
        </BDropdownItem>
      </BDropdown>
      <button
        class="mobile-btn"
        :class="{open: openMenu}"
        @click="openMenu = !openMenu"
      >
        <span></span>
        <span></span>
        <span></span>
      </button>
    </div>
    <div
      class="header-bottom menu-container"
      :class="{'open-menu' : openMenu}"
    >
      <div class="container d-flex align-items-center justify-content-between">
        <ul class="menu overflow-horizontal">
          <li><a href="/">Home</a></li>
          <li><a href="/quienes-somos">Quiénes Somos</a></li>
          <li><a href="/contacto">Contacto</a></li>
          <li><a href="/red-de-medios">Enlaces</a></li>
          <li><a :href="route('search')">Search</a></li>
          <li><a href="/all-rss">All Rss</a></li>
          <li><a href="/all-youtube">All Youtube</a></li>
          <li><a href="http://covid19alert.net" target="_blank">Covid-19 </a></li>
        </ul>
        <SocialIcons/>
      </div>
    </div>
  </header>
</template>

<script>
import {BDropdown, BDropdownItem} from 'bootstrap-vue'
import SocialIcons from './SocialIcons'
import {useLogout} from '~/use'

export default {
  setup() {
    const {logout} = useLogout()
    return {logout}
  },
  components: {
    BDropdown,
    BDropdownItem,
    SocialIcons,
    LanguageSwitcher: () => import('../includes/LanguageSwitcher')
  },
  data() {
    return {
      countries: {...this.shared('countries')},
      openSearch: false,
      openMenu: false,
      isScroll: false,
    }
  },
  beforeMount() {
    ['resize', 'scroll'].forEach(e => addEventListener(e, this.isScrollHeader, false))
  },
  computed: {
    user() {
      return this.$store.state.user
    }
  },
  methods: {
    isScrollHeader() {
      this.isScroll = window.pageYOffset > (window.innerWidth > 767 ? 98 : 24)
    }
  },
}
</script>
