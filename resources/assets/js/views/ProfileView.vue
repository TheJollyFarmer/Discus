<template>
  <v-page @fetch="getData">
    <profile-header :user="user"/>
    <profile-tabs
      :activities="activities"
      @changed="setActiveTab"/>
  </v-page>
</template>

<script>
import api from "../api/activities";
import ProfileHeader from "../components/profile/ProfileHead";
import ProfileTabs from "../components/profile/ProfileTabs";
import ProfileViewBreadcrumbs from "../mixins/ProfileViewBreadcrumbs";
import VPage from "../components/utility/VPage";

export default {
  name: "ProfileView",

  components: {
    ProfileHeader,
    ProfileTabs,
    VPage
  },

  mixins: [ProfileViewBreadcrumbs],

  props: {
    user: {
      type: Object,
      required: true
    }
  },

  data() {
    return {
      selectedTab: "timeline",
      activities: {},
      breadcrumbType: "PROFILE",
      progress: false,
      completed: false
    };
  },

  computed: {
    activityOffset() {
      let offset = 0;

      Object.values(this.activities).forEach(year => {
        Object.values(year).forEach(month => (offset += month.length));
      });

      return offset;
    }
  },

  mounted() {
    this.getActivities();
  },

  methods: {
    setActiveTab(tab) {
      this.selectedTab = tab;
    },

    getData() {
      this.selectedTab === "timeline"
        ? this.getActivities()
        : this.getFriends();
    },

    getActivities() {
      if (!this.progress && !this.completed) {
        this.progress = true;

        api
          .getActivities(this.user.username, this.activityOffset)
          .then(activities => {
            Object.keys(activities).length
              ? this.addActivities(activities)
              : this.setCompleted();
          });
      }
    },

    addActivities(activities) {
      Object.keys(activities).forEach(year => {
        this.activities[year]
          ? this.mergeYear(activities, year)
          : this.addYear(activities, year);
      });

      this.progress = false;
    },

    addYear(activities, year) {
      this.$set(this.activities, year, activities[year]);
    },

    mergeYear(activities, year) {
      Object.keys(activities[year]).forEach(month => {
        this.activities[year][month]
          ? this.mergeMonth(activities, year, month)
          : this.addMonth(activities, year, month);
      });
    },

    mergeMonth(activities, year, month) {
      this.activities[year][month].push(...activities[year][month]);
    },

    addMonth(activities, year, month) {
      this.$set(this.activities[year], month, activities[year][month]);
    },

    setCompleted() {
      this.completed = true;
      this.progress = false;
    }
  }
};
</script>
