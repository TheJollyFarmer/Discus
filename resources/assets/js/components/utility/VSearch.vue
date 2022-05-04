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
  process.env.MIX_ALGOLIA_APP_ID,
  process.env.MIX_ALGOLIA_KEY
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
