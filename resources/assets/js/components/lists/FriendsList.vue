<template>
  <v-data-list
    :data="friends"
    :label="label"
    model="auth/friends"
    #list="{ item: friend }"
    @getData="getData">
    <friends-list-item
      :item="friend"
      @onClick="createChat"/>
  </v-data-list>
</template>

<script>
import FriendsListItem from "./FriendsListItem";
import VDataList from "../utility/VDataList";
import { mapActions, mapGetters } from "vuex";

export default {
  name: "FriendsList",

  components: { FriendsListItem, VDataList },

  props: {
    label: {
      type: String,
      required: false,
      default: "friends"
    },

    truncate: {
      type: Number,
      required: false,
      default: 25
    }
  },

  computed: mapGetters("auth/friends", {
    friends: "getFriends"
  }),

  methods: {
    ...mapActions({
      createGroup: "auth/groups/createGroup",
      getData: "auth/friends/getData",
      toggleContent: "toggleContent",
      openModal: "openModal"
    }),

    createChat(friend) {
      this.toggleContent();

      this.createGroup({
        type: "single",
        users: friend.id
      });
    }
  }
};
</script>
