<template>
  <v-media-object 
    :avatar="item.avatar"
    @onClick="clickEvent">
    <span class="is-size-6 is-flex">{{ item.user }}</span>
  </v-media-object>
</template>

<script>
import filters from "../../utils/filters.js";
import VMediaObject from "../utility/VMediaObject";

export default {
  name: "FriendsListItem",

  components: { VMediaObject },

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
    clickEvent() {
      this.$emit("onClick", this.item);
    }
  }
};
</script>
