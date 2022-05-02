<template>
  <div :class="['menu-item', {'is-active': listActive}]">
    <v-list-item
      class="is-size-6"
      has-link
      @onClick="clickEvent">
      <v-menu-item-icon 
        :icon="icon" 
        :icon-colour="iconColour" 
        :number="number"/>
      <span>
        {{ label }}
      </span>
      <v-rotate
        v-if="hasList"
        :rotate="listActive"/>
    </v-list-item>
    <transition-expand>
      <ul 
        v-if="hasList" 
        v-show="listActive">
        <slot/>
      </ul>
    </transition-expand>
  </div>
</template>

<script>
import api from "../../api";
import TransitionExpand from "../transitions/TransitionExpand";
import VListItem from "./VListItem";
import VMenuItemIcon from "./VMenuItemIcon";
import VRotate from "./VRotate";

export default {
  name: "VMenuItem",

  components: {
    TransitionExpand,
    VListItem,
    VMenuItemIcon,
    VRotate
  },

  props: {
    link: {
      type: String,
      required: false,
      default: ""
    },

    linkData: {
      type: [String, Array, Object],
      required: false,
      default: () => ({})
    },

    icon: {
      type: String,
      required: false,
      default: ""
    },

    iconColour: {
      type: String,
      required: false,
      default: ""
    },

    number: {
      type: Number,
      required: false,
      default: null
    },

    label: {
      type: String,
      required: true
    },

    hasList: {
      type: Boolean,
      required: false,
      default: false
    },

    listActive: {
      type: Boolean,
      required: false,
      default: false
    }
  },

  computed: {
    generateLink() {
      return this.link || this.linkData
        ? this.route(this.link, this.linkData)
        : false;
    }
  },

  methods: {
    route: api.route,

    clickEvent() {
      this.$emit("onClick", this.linkData);
    }
  }
};
</script>

<style lang="scss" scoped>
.menu-item {
  position: relative;
  ul {
    margin: 0.75em;
    height: 200px;
    overflow: hidden;
  }
  &:after {
    background: #00d1b2;
    content: "";
    height: 2.5em;
    position: absolute;
    right: 0;
    top: 0;
    transition: 0.1s;
    width: 0;
  }
  &:hover:after,
  &.is-active:after {
    transition: 0.3s ease-in;
    width: 10px;
  }
}
</style>
