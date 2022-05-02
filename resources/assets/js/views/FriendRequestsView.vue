<template>
  <v-page @fetch="getData">
    <friend-requests-list/>
  </v-page>
</template>

<script>
import FriendRequestsList from "../components/lists/FriendRequestsList";
import ProfileViewBreadcrumbs from "../mixins/ProfileViewBreadcrumbs";
import VPage from "../components/utility/VPage";
import { mapActions } from "vuex";

export default {
  name: "FriendRequestsView",

  components: { FriendRequestsList, VPage },

  mixins: [ProfileViewBreadcrumbs],

  data() {
    return {
      breadcrumbType: "FRIEND_REQUESTS"
    };
  },

  methods: mapActions("auth/friendRequests", ["getData"])
};
</script>
