<template>
  <v-tabs
    class="section-tabs"
    @selected="tabSelectedEvent">
    <v-tab
      icon="list-ul"
      label="timeline"
      :selected="true">
      <profile-activity-feed :activities="activities"/>
    </v-tab>
    <template v-if="isLoggedIn">
      <v-tab
        icon="user-friends"
        label="friends">
        <friends-list/>
      </v-tab>
      <v-tab
        icon="cog"
        label="settings"/>
    </template>
  </v-tabs>
</template>

<script>
import FriendsList from "../lists/FriendsList";
import ProfileActivityFeed from "./activities/ActivityFeed";
import VTab from "../utility/tabs/VTab";
import VTabs from "../utility/tabs/VTabs";
import { mapGetters } from "vuex";

export default {
  name: "ProfileTabs",

  components: {
    FriendsList,
    ProfileActivityFeed,
    VTab,
    VTabs
  },

  props: {
    activities: {
      type: Object,
      required: true
    }
  },

  computed: mapGetters("auth", ["isLoggedIn"]),

  methods: {
    tabSelectedEvent(tab) {
      this.$emit("changed", tab);
    }
  }
};
</script>
