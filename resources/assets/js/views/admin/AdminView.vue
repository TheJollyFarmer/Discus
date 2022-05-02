<template>
  <v-page>
    <v-tabs class="section-tabs">
      <v-tab
        icon="tv"
        label="channels"
        selected>
        <channels-table/>
      </v-tab>
      <v-tab
        icon="layer-group"
        label="threads">
        <!--        <threads-table/>-->
      </v-tab>
    </v-tabs>
  </v-page>
</template>

<script>
import ChannelsTable from "./ChannelsTable";
import ThreadsTable from "./ThreadsTable";
import VPage from "../../components/utility/VPage";
import VTabs from "../../components/utility/tabs/VTabs";
import VTab from "../../components/utility/tabs/VTab";
import { mapActions } from "vuex";

export default {
  name: "AdminView",

  components: {
    ChannelsTable,
    ThreadsTable,
    VTab,
    VTabs,
    VPage
  },

  props: {
    channels: {
      type: Array,
      required: true
    },

    threads: {
      type: Array,
      required: true
    }
  },

  created() {
    this.setChannels(this.channels);
  },

  methods: mapActions("admin/channels", ["setChannels"])
};
</script>
