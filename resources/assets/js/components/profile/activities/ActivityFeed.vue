<template>
  <v-timeline class="is-centered">
    <template v-for="(year, index) in activities">
      <v-timeline-header
        :key="index"
        :label="index"/>
      <template v-for="(month, key) in year">
        <v-timeline-header
          :key="key"
          :label="key"/>
        <template v-for="activity in month">
          <component
            :is="activityType(activity.type)"
            :key="activity.id"
            :activity="activity"/>
        </template>
      </template>
    </template>
    <v-timeline-header
      :label="timelineHeaderEndLabel"
      size="is-medium"/>
  </v-timeline>
</template>

<script>
import ActivityFavourite from "./ActivityFavourite";
import ActivityReply from "./ActivityReply";
import ActivityThread from "./ActivityThread";
import filters from "../../../utils/filters";
import VTimeline from "../../utility/timeline/VTimeline";
import VTimelineHeader from "../../utility/timeline/VTimelineHeader";
import VTimelineItem from "../../utility/timeline/VTimelineItem";

export default {
  name: "ProfileActivityFeed",

  components: {
    ActivityFavourite,
    ActivityReply,
    ActivityThread,
    VTimeline,
    VTimelineItem,
    VTimelineHeader
  },

  props: {
    activities: {
      type: Object,
      required: true
    }
  },

  computed: {
    timelineHeaderEndLabel() {
      return "...";
    }
  },

  methods: {
    activityType(type) {
      return "Activity" + filters.capitalise(type.split("_").pop());
    }
  }
};
</script>
