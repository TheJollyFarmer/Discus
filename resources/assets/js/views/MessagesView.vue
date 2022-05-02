<template>
  <v-page
    class="paddingless-bottom"
    @infiniteScroll="false">
    <div class="columns">
      <div class="column is-one-third">
        <messages-list
          :truncate="18"
          load="page"
          @loadChat="setGroup"/>
      </div>
      <div class="column is-two-thirds">
        <chat
          v-show="group"
          :display="true"
          :group="group"/>
      </div>
    </div>
  </v-page>
</template>

<script>
import Chat from "../components/chat/Chat";
import MessagesList from "../components/lists/MessagesList";
import ProfileViewBreadcrumbs from "../mixins/ProfileViewBreadcrumbs";
import VPage from "../components/utility/VPage";

export default {
  name: "MessagesView",

  components: { Chat, MessagesList, VPage },

  mixins: [ProfileViewBreadcrumbs],

  data() {
    return {
      group: 0,
      breadcrumbType: "MESSAGES"
    };
  },

  methods: {
    setGroup(message) {
      this.group = message.group;

      this.$nextTick(() => {
        this.displayMessages = false;
      });
    }
  }
};
</script>

<style scoped lang="scss">
.paddingless-bottom {
  padding-bottom: 0;
}

.columns {
  height: 80.5vh;
  .column {
    padding-bottom: 0;
    &:first-of-type {
      border-right: 1px solid #dbdbdb;
      padding-right: 0;
    }
    &:last-of-type .is-two-thirds {
      padding-left: 0;
    }
  }
}
</style>
