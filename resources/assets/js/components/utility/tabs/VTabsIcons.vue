<template>
  <ul>
    <li
      v-for="(tab, index) in tabs"
      :key="index"
      :class="{ 'is-active': tab.isActive }">
      <a
        v-tooltip="tab.label"
        role="tab"
        @click="selectEvent(tab, index)">
        <v-favicon :icon="tab.icon"/>
      </a>
    </li>
  </ul>
</template>

<script>
import VFavicon from "../VFavicon";

export default {
  name: "VTabsIcons",

  components: { VFavicon },

  props: {
    tabs: {
      type: Array,
      required: true
    }
  },

  methods: {
    selectEvent(tab, index) {
      this.$emit("select", tab, index);
    }
  }
};
</script>

<style lang="scss" scoped>
li.is-active a {
  border-bottom-color: #00d1b2;
  color: #00d1b2;
}

li .icon:first-child {
  margin-right: 0;
}
</style>
