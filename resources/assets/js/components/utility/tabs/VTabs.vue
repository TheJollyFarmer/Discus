<template>
  <div>
    <div class="tabs is-fullwidth is-marginless">
      <v-tabs-icons 
        :tabs="tabs" 
        @select="selectTab"/>
    </div>
    <div class="tab-content">
      <slot/>
    </div>
  </div>
</template>

<script>
import VTabsIcons from "./VTabsIcons";

export default {
  name: "VTabs",

  components: { VTabsIcons },

  data() {
    return {
      tabs: [],
      activeTab: 0
    };
  },

  methods: {
    selectTab(selectedTab, index) {
      this.tabs.forEach(tab => {
        tab.isActive = tab === selectedTab;
      });

      this.$emit("selected", selectedTab);

      this.setTabTransition(this.tabs[this.activeTab], index);
      this.setTabTransition(selectedTab, index);

      this.activeTab = index;
    },

    setTabTransition(tab, index) {
      index < this.activeTab
        ? (tab.transitionType = "next")
        : (tab.transitionType = "prev");
    }
  }
};
</script>

<style lang="scss" scoped>
.tabs {
  overflow: visible;
  position: relative;
  z-index: 10;
}

.tab-content {
  display: flex;
  flex-flow: column;
}
</style>
