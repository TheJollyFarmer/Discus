<template>
  <blockquote class="quote">
    {{ quote | truncate(truncate) }}
  </blockquote>
</template>

<script>
import filters from "../../utils/filters";

export default {
  name: "VQuote",

  filters: {
    truncate: filters.truncate
  },

  props: {
    quote: {
      type: String,
      required: true
    },

    truncate: {
      type: Number,
      required: false,
      default: 90
    }
  }
};
</script>

<style scoped>
.quote {
  border-left: 5px solid #00d1b2;
  padding-left: 1em;
  margin: 1em 0;
}
</style>
