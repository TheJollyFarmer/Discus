<template>
  <activity
    v-slot="{ activity }"
    :activity="activity"
    type="threads"
    icon="layer-group"
    classes="is-dark">
    <v-button
      icon="eye"
      class="is-outlined">
      {{ activity.comments }}
    </v-button>
    <v-button
      icon="reply-all"
      class="is-outlined">
      {{ activity.visits }}
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
  name: "ActivityThread",

  components: { Activity, VButton },

  props: {
    activity: {
      type: Object,
      required: true
    }
  }
};
</script>
