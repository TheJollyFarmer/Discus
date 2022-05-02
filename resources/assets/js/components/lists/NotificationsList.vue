<template>
  <v-data-list
    :data="notifications"
    :label="label"
    model="auth/notifications"
    #list="{ item: notifiation }"
    @getData="getData">
    <notifications-list-item
      :item="notifiation"
      :truncate="truncate"
      @onClick="getLink"
      @onToggle="toggleMarkAs"/>
  </v-data-list>
</template>

<script>
import api from "../../api/index";
import NotificationsListItem from "./NotificationsListItem";
import VDataList from "../utility/VDataList";
import { mapActions, mapGetters } from "vuex";

export default {
  name: "NotficationsList",

  components: { NotificationsListItem, VDataList },

  props: {
    label: {
      type: String,
      required: false,
      default: "notifications"
    },

    truncate: {
      type: Number,
      required: false,
      default: 25
    }
  },

  computed: mapGetters("auth/notifications", {
    notifications: "getNotifications"
  }),

  methods: {
    ...mapActions("auth/notifications", ["getData", "generateLink", "markAs"]),

    getLink(notification, type) {
      type === "UserMadeAFriend"
        ? api.goTo("profiles.show", notification.user)
        : this.generateLink(notification);
    },

    toggleMarkAs(notification) {
      this.markAs({
        id: notification.id,
        marked: notification.read ? "true" : ""
      });
    }
  }
};
</script>
