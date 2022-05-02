<template>
  <v-data-list
    :data="threads"
    :label="label"
    model="threads"
    #list="{ item: thread }"
    @getData="getData">
    <threads-list-item
      :thread="thread"
      :truncate="truncate"/>
  </v-data-list>
</template>

<script>
import ThreadsListItem from "./ThreadsListItem";
import VDataList from "../utility/VDataList";
import { mapActions, mapGetters } from "vuex";

export default {
  name: "ThreadsList",

  components: { ThreadsListItem, VDataList },

  props: {
    label: {
      type: String,
      required: false,
      default: "threads"
    },

    truncate: {
      type: Number,
      required: false,
      default: 500
    }
  },

  computed: mapGetters("threads", {
    threads: "getThreads"
  }),

  created() {
    this.getData();
  },

  methods: mapActions("threads", ["getData"])
};
</script>

<style scoped>
::v-deep .dropdown-item {
  padding-bottom: 0;
  white-space: normal;
}
</style>
