<template>
  <activity
    v-slot="{ activity }"
    :activity="activity"
    icon="reply"
    classes="is-primary">
    <v-button
      v-if="activity.isBest"
      icon="star"
      class="is-outlined"/>
    <v-button
      v-if="activity.favourites > 0"
      icon="heart"
      class="is-outlined">
      {{ activity.favourites }}
    </v-button>
    <v-button class="is-outlined">
      XP +22
    </v-button>
  </activity>
</template>

<script>
import Activity from "./Activity";
import VButton from "../../utility/VButton";

export default {
  name: "ActivityReply",

  components: { Activity, VButton },

  props: {
    activity: {
      type: Object,
      required: true
    }
  }
};
</script>
