<template>
  <activity
    :activity="activity"
    icon="star"
    type="favourites"
    classes="is-link"/>
</template>

<script>
import Activity from "./Activity";

export default {
  name: "ActivityFavourite",

  components: { Activity },

  props: {
    activity: {
      type: Object,
      required: true
    }
  }
};
</script>
