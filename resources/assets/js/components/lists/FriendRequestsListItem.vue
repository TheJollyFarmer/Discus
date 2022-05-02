<template>
  <v-media-object :avatar="item.avatar">
    <a :href="route('profiles.show', item.user)">
      <strong>{{ item.user }}</strong>
    </a>
    <div>{{ item.created | localTime }}</div>
    <template #mediaRight>
      <div class="buttons">
        <v-button
          icon="check"
          @onClick="submitEvent"/>
        <v-button
          icon="times"
          class="is-danger"
          @onClick="declineEvent"/>
      </div>
    </template>
  </v-media-object>
</template>

<script>
import api from "../../api/index";
import filters from "../../utils/filters";
import VButton from "../utility/VButton";
import VMediaObject from "../utility/VMediaObject";

export default {
  name: "FriendRequestListItem",

  components: { VButton, VMediaObject },

  filters: {
    truncate: filters.truncate,
    localTime: filters.localTime
  },

  props: {
    item: {
      type: Object,
      required: true
    },

    truncate: {
      type: Number,
      required: false,
      default: null
    }
  },

  methods: {
    route: api.route,

    submitEvent() {
      this.$emit("submit", this.item.id);
    },

    declineEvent() {
      this.$emit("decline", this.item.id);
    }
  }
};
</script>
