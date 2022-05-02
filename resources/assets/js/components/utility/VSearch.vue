<template>
  <ais-instant-search
    :search-client="searchClient"
    :index-name="model">
    <slot/>
  </ais-instant-search>
</template>

<script>
import { AisInstantSearch } from "vue-instantsearch";
import algoliasearch from "algoliasearch/lite";

const searchClient = algoliasearch(
  "R4P9YRNAU6",
  "8abfc862fb95261593b7842250606188"
);

export default {
  name: "VSearch",

  components: { AisInstantSearch },

  props: {
    model: {
      type: String,
      required: false,
      default: "threads"
    }
  },

  data() {
    return {
      searchClient
    };
  }
};
</script>
