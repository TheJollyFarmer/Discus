<template>
  <div class="content">
    <v-level class="thread-head">
      <thread-content-labels
        v-model="title"
        :editing="editing"
        :username="thread.username"/>
      <template #levelRight>
        <thread-content-stats/>
      </template>
    </v-level>
    <v-wysiwyg
      v-model="body"
      :editing="editing"/>
  </div>
</template>

<script>
import ThreadContentLabels from "./ThreadContentLabels";
import ThreadContentStats from "./ThreadContentStats";
import VLevel from "../utility/VLevel";
import VWysiwyg from "../utility/VWysiwyg";
import { mapActions, mapGetters } from "vuex";

export default {
  name: "ThreadContent",

  components: {
    ThreadContentLabels,
    ThreadContentStats,
    VLevel,
    VWysiwyg
  },

  props: {
    thread: {
      type: Object,
      required: true
    }
  },

  computed: {
    ...mapGetters("threads/thread", {
      editing: "isEditing",
      editTitle: "getEditTitle",
      editBody: "getEditBody"
    }),

    title: {
      get() {
        return this.editTitle;
      },

      set(value) {
        this.updateTitle(value);
      }
    },

    body: {
      get() {
        return this.editBody;
      },

      set(value) {
        this.updateBody(value);
      }
    }
  },

  methods: mapActions("threads/thread", {
    updateTitle: "setEditTitle",
    updateBody: "setEditBody"
  })
};
</script>

<style scoped>
.thread-head {
  font-weight: bold;
  margin-bottom: 0.75rem;
}
</style>
