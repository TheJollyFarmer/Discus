<template>
  <div>
    <div class="profile-name">
      {{ user.name }}
    </div>
    <div>
      <v-favicon icon="calendar-alt"/>
      {{ user.created_at | localTime }}
    </div>
    <div>
      <v-favicon icon="star"/>
      {{ user.reputation }}
    </div>
  </div>
</template>

<script>
import filters from "../../utils/filters.js";
import VFavicon from "../utility/VFavicon";

export default {
  name: "ProfileHeadLabels",

  components: { VFavicon },

  filters: {
    localTime: filters.localTime
  },

  props: {
    user: {
      type: Object,
      required: true
    }
  }
};
</script>

<style scoped>
.profile-name {
  font-weight: 600;
  padding-left: 0.3em;
}
</style>
