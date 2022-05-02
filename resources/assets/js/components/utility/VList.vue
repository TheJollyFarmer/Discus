<template>
  <transition-list>
    <template v-if="collection">
      <v-list-item
        v-for="(item, index) in collection"
        :key="item.id || item"
        :has-link="hasLinks"
        :class="{ 'is-active' : isActive(index) }">
        <slot
          :item="item"
          :index="index"
          name="list"/>
      </v-list-item>
    </template>
    <slot/>
  </transition-list>
</template>

<script>
import TransitionList from "../transitions/TransitionList";
import VListItem from "./VListItem";

export default {
  name: "VList",

  components: { TransitionList, VListItem },

  props: {
    collection: {
      type: [Array, Object],
      required: false,
      default: null
    },

    model: {
      type: String,
      required: false,
      default: null
    },

    hasLinks: {
      type: Boolean,
      required: false,
      default: true
    },

    selected: {
      type: Number,
      required: false,
      default: null
    },

    offset: {
      type: Number,
      required: false,
      default: 0
    }
  },

  methods: {
    isActive(index) {
      return this.selected === index + 1 + this.offset;
    }
  }
};
</script>
