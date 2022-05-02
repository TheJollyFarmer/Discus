<template>
  <v-media-object 
    :avatar="item.avatar"
    @onClick="clickEvent">
    <strong>{{ item.user }}</strong>
    <div>{{ item.body | truncate(truncate) }}</div>
    <div>{{ item.created | localTime }}</div>
    <template #mediaRight="{ hover }">
      <v-toggle
        v-show="hover"
        :is-active="!item.read"
        @toggled="toggleEvent"/>
    </template>
  </v-media-object>
</template>

<script>
import filters from "../../utils/filters.js";
import VMediaObject from "../utility/VMediaObject";
import VToggle from "../utility/VToggle";

export default {
  name: "MessagesListItem",

  components: { VMediaObject, VToggle },

  filters: {
    truncate: filters.truncate,
    localTime: filters.localTime
  },

  props: {
    item: {
      type: Object,
      required: true
    },

    truncate: {
      type: Number,
      required: false,
      default: null
    }
  },

  methods: {
    toggleEvent() {
      this.$emit("onToggle", this.item);
    },

    clickEvent() {
      this.$emit("onClick", this.item);
    }
  }
};
</script>
