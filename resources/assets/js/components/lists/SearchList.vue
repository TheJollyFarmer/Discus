<template>
  <v-scroll :class="['flex', calcHeight]">
    <v-list
      v-if="hits"
      :collection="allHits"
      #list="{ item: hit }"
      :selected="selected">
      <search-list-item 
        :item="hit"
        @onClick="goToPage"/>
    </v-list>
    <v-error
      v-else
      text="Sorry, it appears there are no results."/>
  </v-scroll>
</template>

<script>
import api from "../../api/index";
import SearchListItem from "./SearchListItem";
import VList from "../utility/VList";
import VScroll from "../utility/VScroll";
import VError from "../utility/VError";

export default {
  name: "SearchList",

  components: {
    SearchListItem,
    VError,
    VList,
    VScroll
  },

  props: {
    indices: {
      type: Array,
      required: true
    },

    selected: {
      type: Number,
      required: false,
      default: null
    }
  },

  computed: {
    hitsCount() {
      return this.indices[0].hits.length + this.indices[1].hits.length;
    },

    hits() {
      return this.hitsCount > 0;
    },

    calcHeight() {
      return this.hitsCount > 5 ? "isHeight" : "";
    },

    allHits() {
      return this.indices[0].hits.concat(this.indices[1].hits);
    }
  },

  methods: {
    goToPage({ path, params }) {
      setTimeout(() => {
        api.goTo(path, params);
      }, 150);
    }
  }
};
</script>

<style lang="scss" scoped>
.isHeight {
  height: 30em;
  overflow: hidden;
  > div {
    height: 100%;
  }
}
</style>
