<template>
  <div :class="['navbar-item has-dropdown', { 'is-active': isActive }]">
    <v-nav-item
      v-tooltip:bottom="label"
      :icon="icon"
      :unread-count="count"
      @onClick="toggleDropdown"/>
    <transition-dropdown>
      <div
        v-show="isActive"
        class="navbar-dropdown is-right">
        <slot :closeDropdown="toggleDropdown"/>
      </div>
    </transition-dropdown>
  </div>
</template>

<script>
import Dropdown from "../../mixins/Dropdown";
import TransitionDropdown from "../transitions/TransitionDropdown";
import VNavItem from "./VNavItem";

export default {
  name: "VNavDropdown",

  components: { VNavItem, TransitionDropdown },

  mixins: [Dropdown],

  props: {
    icon: {
      type: String,
      required: true
    },

    label: {
      type: String,
      required: true
    },

    count: {
      type: Number,
      required: true,
      default: 0
    }
  }
};
</script>

<style lang="scss" scoped>
.navbar-item {
  perspective: 2000px;
  z-index: 1;
  .navbar-dropdown.is-right {
    display: flex;
    flex-direction: column;
    height: 33em;
    min-width: 27.6em;
  }
  &.is-active {
    z-index: 0;
    ::v-deep .tooltip-container > .tooltip {
      visibility: hidden;
    }
  }
}
</style>
