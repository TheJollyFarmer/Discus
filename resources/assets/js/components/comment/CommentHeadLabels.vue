<template>
  <div>
    <a
      :href="route('profiles.show', comment.username)"
      v-text="comment.username"/>
    <div>{{ comment.created | localTime }}</div>
  </div>
</template>

<script>
import api from "../../api/index";
import filters from "../../utils/filters";

export default {
  name: "CommentHeadLabels",

  filters: {
    localTime: filters.localTime
  },

  props: {
    comment: {
      type: Object,
      required: true
    }
  },

  methods: {
    route: api.route
  }
};
</script>
