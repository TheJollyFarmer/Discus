<template>
  <v-page @fetch="getData">
    <notfications-list :truncate="80"/>
  </v-page>
</template>

<script>
import NotficationsList from "../components/lists/NotificationsList";
import ProfileViewBreadcrumbs from "../mixins/ProfileViewBreadcrumbs";
import VPage from "../components/utility/VPage";
import { mapActions } from "vuex";

export default {
  name: "NotificationsView",

  components: { NotficationsList, VPage },

  mixins: [ProfileViewBreadcrumbs],

  data() {
    return {
      breadcrumbType: "NOTIFICATIONS"
    };
  },

  methods: mapActions("auth/notifications", ["getData"])
};
</script>
