<template>
  <v-table>
    <v-t-head :header="header"/>
    <v-t-body
      c-key="slug"
      :data="channels">
      <td slot-scope="{ row }">
        <v-favicon
          icon="edit"
          @click.native="editChannel(row)"/>
      </td>
    </v-t-body>
  </v-table>
</template>

<script>
import VFavicon from "../../components/utility/VFavicon";
import VTable from "../../components/utility/VTable";
import VTHead from "../../components/utility/VThead";
import VTBody from "../../components/utility/VTBody";
import { mapActions, mapState } from "vuex";

export default {
  name: "ChannelsTable",

  components: {
    VFavicon,
    VTable,
    VTBody,
    VTHead
  },

  data() {
    return {
      header: ["Name", "Slug", "Description", "Threads", "Actions"]
    };
  },

  computed: mapState("admin/channels", {
    channels: state => state.data
  }),

  methods: mapActions("admin/channels", ["editChannel"])
};
</script>
