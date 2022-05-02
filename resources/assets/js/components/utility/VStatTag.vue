<template>
  <div class="control">
    <v-tags addons>
      <v-tag>
        <v-favicon :icon="icon"/>
      </v-tag>
      <v-tag type="is-dark">
        {{ stat || 14 }}
      </v-tag>
    </v-tags>
  </div>
</template>

<script>
import VFavicon from "./VFavicon";
import VTag from "./VTag";
import VTags from "./VTags";

export default {
  name: "VStatTag",

  components: { VFavicon, VTag, VTags },

  props: {
    icon: {
      type: String,
      required: true
    },

    stat: {
      type: [String, Number],
      required: true
    }
  }
};
</script>

<style scoped>
.control > .tags {
  width: 4.7em;
}
</style>
