<template>
  <div @click.stop>
    <a :href="route('threads.show', [thread.channelSlug, thread.slug])">
      <h4 class="has-text-dark">
        {{ thread.title | truncate(truncate) }}
      </h4>
    </a>
    <a 
      :href="route('profiles.show', thread.username)" 
      class="has-text-weight-semibold">
      {{ thread.username }}
    </a>
  </div>
</template>

<script>
import api from "../../api";
import filters from "../../utils/filters";

export default {
  name: "ThreadHeadLabels",

  filters: {
    truncate: filters.truncate
  },

  props: {
    thread: {
      type: Object,
      required: true
    },

    truncate: {
      type: Number,
      required: false,
      default: 50
    }
  },

  methods: {
    route: api.route
  }
};
</script>
