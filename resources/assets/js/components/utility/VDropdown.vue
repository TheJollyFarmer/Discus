<template>
  <div :class="['dropdown', { 'is-active': isActive }]">
    <div 
      class="dropdown-trigger" 
      @click="toggleDropdown">
      <slot name="dropdownTrigger">
        <v-favicon :icon="icon"/>
      </slot>
    </div>
    <transition-dropdown>
      <div
        v-show="isActive"
        class="dropdown-menu"
        role="menu">
        <div class="dropdown-content">
          <slot :closeDropdown="toggleDropdown"/>
        </div>
      </div>
    </transition-dropdown>
  </div>
</template>

<script>
import Dropdown from "../../mixins/Dropdown";
import TransitionDropdown from "../transitions/TransitionDropdown";
import VFavicon from "./VFavicon";

export default {
  name: "VDropdown",

  components: { VFavicon, TransitionDropdown },

  mixins: [Dropdown],

  props: {
    icon: {
      type: String,
      required: true
    }
  }
};
</script>

<style lang="scss" scoped>
.dropdown {
  perspective: 2000px;
  z-index: 2;
}
</style>
