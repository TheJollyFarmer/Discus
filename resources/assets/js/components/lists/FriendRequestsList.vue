<template>
  <v-data-list
    :data="requests"
    :label="label"
    model="auth/friendRequests"
    #list="{ item: request }"
    @getData="getData">
    <friend-requests-list-item
      :item="request"
      @submit="acceptRequest"
      @decline="declineRequest"/>
  </v-data-list>
</template>

<script>
import FriendRequestsListItem from "./FriendRequestsListItem";
import VDataList from "../utility/VDataList";
import { mapActions, mapGetters } from "vuex";

export default {
  name: "FriendRequestsList",

  components: { FriendRequestsListItem, VDataList },

  props: {
    label: {
      type: String,
      required: false,
      default: "friendRequests"
    },

    truncate: {
      type: Number,
      required: false,
      default: 25
    }
  },

  computed: mapGetters("auth/friendRequests", {
    requests: "getRequests"
  }),

  methods: {
    ...mapActions("auth/friendRequests", [
      "getData",
      "acceptFriendRequest",
      "declineFriendRequest"
    ]),

    acceptRequest(friend) {
      this.acceptFriendRequest(friend);
    },

    declineRequest(friend) {
      this.declineFriendRequest(friend);
    }
  }
};
</script>
