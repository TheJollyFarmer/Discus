<template>
  <div class="navbar-item">
    <v-search>
      <v-auto-complete 
        :indices="[{ label: 'Users', value: 'users' }]"
        @itemSelected="setSelectedItem"
        @clearItem="clearSelectedItem"
        @loadItem="loadPage">
        <template #default="{ indices }">
          <transition-fade>
            <search-list
              :indices="indices"
              :selected="selected"/>
          </transition-fade>
        </template>
      </v-auto-complete>
    </v-search>
  </div>
</template>

<script>
import api from "../../api/index";
import SearchList from "../lists/SearchList";
import TransitionFade from "../transitions/TransitionFade";
import VAutoComplete from "../utility/VAutoComplete";
import VSearch from "../utility/VSearch";

export default {
  name: "NavSearch",

  components: {
    SearchList,
    TransitionFade,
    VAutoComplete,
    VSearch
  },

  data() {
    return {
      selected: 0
    };
  },

  methods: {
    setSelectedItem(direction, length) {
      if (length === 0) return (this.selected = 0);

      if (direction === "up" && this.selected > 0) {
        this.selected--;
      } else if (direction === "down" && this.selected < length) {
        this.selected++;
      } else if (direction === "down") {
        this.selected = 1;
      } else {
        this.selected = 0;
      }
    },

    clearSelectedItem(length) {
      if (this.selected > length) {
        this.selected = 0;
      }
    },

    loadPage(hits) {
      let item = hits[this.selected - 1];
      let link = this.createLink(item);

      api.goTo(link.path, link.params);
    },

    createLink(item) {
      return item.creator
        ? {
            path: "threads.show",
            params: [item.channel.slug, item.slug]
          }
        : { path: "profiles.show", params: item.username };
    }
  }
};
</script>

<style lang="scss" scoped>
.navbar-item {
  cursor: pointer;
  padding: 0.5rem;
  &:hover:not(:focus-within) {
    background-color: #00b89c;
  }
}
</style>
