<template>
  <v-media-object 
    :avatar="avatarPath" 
    @onClick="clickEvent">
    <strong>
      <div v-html="truncatedAttribute"/>
    </strong>
    <div v-if="isThread">
      {{ item.body | truncate(25) }}
    </div>
    <div v-else>
      {{ item.reputation }}
    </div>
    <template #mediaRight>
      <v-favicon 
        :icon="iconType" 
        class="searchListIcon"/>
    </template>
  </v-media-object>
</template>

<script>
import filters from "../../utils/filters";
import VFavicon from "../utility/VFavicon";
import VMediaObject from "../utility/VMediaObject";

export default {
  name: "SearchListItem",

  components: { VFavicon, VMediaObject },

  filters: {
    truncate: filters.truncate
  },

  props: {
    item: {
      type: Object,
      required: true
    }
  },

  computed: {
    isThread() {
      return !!this.item.creator;
    },

    truncatedAttribute() {
      return filters.truncate(
        this.item._highlightResult[this.attributeToHighlight].value,
        38
      );
    },

    avatarPath() {
      return this.isThread
        ? this.item.creator.avatar_path
        : this.item.avatar_path;
    },

    attributeToHighlight() {
      return this.isThread ? "title" : "username";
    },

    iconType() {
      return this.isThread ? "layer-group" : "user";
    }
  },

  methods: {
    clickEvent() {
      this.$emit("onClick", this.createLink());
    },

    createLink() {
      return this.isThread
        ? {
            path: "threads.show",
            params: [this.item.channel.slug, this.item.slug]
          }
        : { path: "profiles.show", params: this.item.username };
    }
  }
};
</script>

<style scoped>
.searchListIcon {
  margin: 0 !important;
}
</style>
