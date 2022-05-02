<template>
  <v-media-object
    :avatar="item.avatar"
    :title="title"
    @onClick="clickEvent">
    <strong>{{ item.user | truncate(0.6 * truncate) }}</strong>
    <span> {{ titleTypeText | truncate(0.4 * truncate) }} </span>
    <div>{{ item.body | truncate(truncate) }}</div>
    <div>{{ item.created | localTime }}</div>
    <template #mediaRight="{ hover }">
      <v-toggle
        v-show="hover"
        :is-active="!item.read"
        @toggled="toggleEvent"/>
    </template>
  </v-media-object>
</template>

<script>
import filters from "../../utils/filters.js";
import VMediaObject from "../utility/VMediaObject";
import VToggle from "../utility/VToggle";

export default {
  name: "NotificationsListItem",

  components: { VMediaObject, VToggle },

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
      default: 25
    }
  },

  computed: {
    title() {
      return this.item.user + this.titleTypeText;
    },

    type() {
      return this.item.type.split("\\").pop();
    },

    titleTypeText() {
      switch (this.type) {
        case "ThreadWasUpdated":
          return ` replied to ${this.item.title}`;

        case "UserMadeAFriend":
          return " added you as a friend";

        case "UserWasTagged":
          return ` tagged you in ${this.item.title}`;
      }
    }
  },

  methods: {
    toggleEvent() {
      this.$emit("onToggle", this.item);
    },

    clickEvent() {
      this.$emit("onClick", this.item);

      if (!this.item.read) {
        this.toggleEvent();
      }
    }
  }
};
</script>
