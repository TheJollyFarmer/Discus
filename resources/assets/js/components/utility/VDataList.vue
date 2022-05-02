<template>
  <v-data-scroll
    :label="label"
    :model="model"
    :data="dataCount"
    :is-infinite-scroll-top="isChat"
    @infiniteScroll="infiniteScrollEvent">
    <v-list
      :collection="data"
      :has-links="links"
      #list="{ item }">
      <slot
        :item="item"
        name="list"/>
    </v-list>
    <slot/>
  </v-data-scroll>
</template>

<script>
import VDataScroll from "./VDataScroll";
import VList from "./VList";

export default {
  name: "VDataList",

  components: {
    VDataScroll,
    VList
  },

  props: {
    label: {
      type: String,
      required: true
    },

    model: {
      type: String,
      required: false,
      default: ""
    },

    data: {
      type: [Array, Object],
      required: true,
      default: function() {
        return [];
      }
    },

    links: {
      type: Boolean,
      required: false,
      default: true
    },

    isChat: {
      type: Boolean,
      required: false,
      default: false
    }
  },

  computed: {
    dataCount() {
      return Array.isArray(this.data)
        ? this.data.length
        : Object.keys(this.data).length;
    }
  },

  methods: {
    infiniteScrollEvent() {
      this.$emit("getData");
    }
  }
};
</script>
