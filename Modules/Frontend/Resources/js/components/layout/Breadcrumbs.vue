<template>
  <nav aria-label="breadcrumb" class="nav-breadcrumb">
    <ol class="breadcrumb">
      <li
        v-for="{title,url} in items"
        :class="{active:url}"
        class="breadcrumb-item">
        <a
          v-if="url"
          :href="url">
          {{ title }}
        </a>
        {{ !url ? title : '' }}
      </li>
    </ol>
  </nav>
</template>

<script>
export default {
  props: {
    items: Array
  }
}
</script>
