<template>
  <v-level-item
    v-tooltip.list="otherUsers"
    class="is-size-6 has-text-weight-semibold">
    {{ users[0].user }}...
  </v-level-item>
</template>

<script>
import VLevelItem from "../utility/VLevelItem";

export default {
  name: "ChatWindowHeadTitle",

  components: { VLevelItem },

  props: {
    users: {
      type: Array,
      required: true
    }
  },

  computed: {
    otherUsers() {
      return this.users.slice(1);
    }
  }
};
</script>
