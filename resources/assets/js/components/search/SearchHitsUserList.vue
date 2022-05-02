<template>
  <v-data-scroll
    :data="hits.length"
    label="friends">
    <v-list
      :collection="hits"
      #list="{ item: user, index }">
      <search-hits-list-item
        :item="item"
        :is-active="isActiveItem(item)"
        @onClick="clickEvent(item, index)"/>
    </v-list>
  </v-data-scroll>
</template>

<script>
import VDataScroll from "../utility/VDataScroll";
import VList from "../utility/VList";
import SearchHitsListItem from "./SearchHitsListItem";

export default {
  name: "SearchHitsUserList",

  components: {
    SearchHitsListItem,
    VDataScroll,
    VList
  },

  props: {
    hits: {
      type: [Array, Object],
      required: true
    },

    users: {
      type: Array,
      required: true
    }
  },

  methods: {
    isActiveItem(item) {
      return this.users.some(user => user === item);
    },

    clickEvent(item, index) {
      this.isActiveItem(item)
        ? this.$emit("remove", index)
        : this.$emit("add", item);
    }
  }
};
</script>
