<template>
  <v-nav-dropdown
    :count="unreadCount"
    :icon="icon"
    :label="label">
    <template #default="{ closeDropdown }">
      <div class="dropdown-item">
        <v-level>
          <div class="is-capitalized">
            {{ label }}
          </div>
          <template #levelRight>
            <a
              v-if="component !== 'friendRequests'"
              @click="markAllAsRead">
              Mark All As Read
            </a>
          </template>
        </v-level>
      </div>
      <component
        :is="`${component}-list`"
        :label="label"
        @click.native="closeDropdown"/>
      <div class="dropdown-item has-text-centered">
        <a
          :href="route(`${link}.index`, auth)"
          class="is-capitalized">
          Go to {{ label }}
        </a>
      </div>
    </template>
  </v-nav-dropdown>
</template>

<script>
import api from "../../api/index";
import FriendRequestsList from "../lists/FriendRequestsList";
import MessagesList from "../lists/MessagesList";
import NotificationsList from "../lists/NotificationsList";
import VLevel from "../utility/VLevel";
import VNavDropdown from "../utility/VNavDropdown";
import { mapState } from "vuex";

export default {
  name: "NavDropdown",

  components: {
    FriendRequestsList,
    MessagesList,
    NotificationsList,
    VLevel,
    VNavDropdown
  },

  props: {
    icon: {
      type: String,
      required: true
    },

    label: {
      type: String,
      required: true
    },

    component: {
      type: String,
      required: true
    },

    link: {
      type: String,
      required: true
    }
  },

  computed: mapState({
    auth: state => state.auth.user.username,
    unreadCount(state) {
      return state.auth[this.component].unreadCount;
    }
  }),

  methods: {
    route: api.route,

    markAllAsRead() {
      this.$store.dispatch(`auth/${this.component}/markAllAsRead`);
    }
  }
};
</script>

<style lang="scss" scoped>
.dropdown-item {
  padding-top: 0;
  &.has-text-centered {
    padding-bottom: 0;
    padding-top: 0.375rem;
  }
}
</style>
