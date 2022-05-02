<template>
  <v-tabs>
    <v-tab
      :selected="true"
      label="links"
      icon="home">
      <links-tab :user="username"/>
    </v-tab>
    <v-tab
      icon="envelope"
      label="messages">
      <messages-tab/>
    </v-tab>
    <v-tab
      icon="bell"
      label="notifications">
      <notfications-list :truncate="18"/>
    </v-tab>
    <v-tab
      icon="user"
      label="friends">
      <friend-list-tab/>
    </v-tab>
  </v-tabs>
</template>

<script>
import FriendListTab from "./FriendListTab";
import LinksTab from "./LinksTab";
import MessagesTab from "./MessagesTab";
import NotficationsList from "../lists/NotificationsList";
import VTab from "../utility/tabs/VTab";
import VTabs from "../utility/tabs/VTabs";

export default {
  name: "UserPanelTabs",

  components: {
    FriendListTab,
    LinksTab,
    MessagesTab,
    NotficationsList,
    VTab,
    VTabs
  },

  props: {
    username: {
      type: String,
      required: true
    }
  }
};
</script>

<style lang="scss" scoped>
::v-deep .tabs {
  box-shadow: #4a4a4a 0px -2px 20px -4px;
}

::v-deep .tab-content {
  height: calc(100vh - 16.9em);
  > div {
    height: calc(100vh - 16.9em);
    overflow: hidden;
    > :first-child {
      display: flex;
      flex-direction: column;
      height: 100%;
    }
  }
}
</style>
