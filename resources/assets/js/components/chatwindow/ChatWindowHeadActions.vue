<template>
  <div class="level-right">
    <v-level-item v-tooltip="'Add Users'">
      <v-favicon
        icon="user-plus"
        @click.native="toggleInput"/>
    </v-level-item>
    <v-level-item v-tooltip="'Settings'">
      <v-dropdown 
        v-slot="{ closeDropdown }" 
        icon="cog">
        <chat-menu 
          custom-class="is-marginless"
          @leaveChat="leaveChat"
          @deleteChat="deleteChat"
          @toggleInput="toggleInput"
          @click.native="closeDropdown"/>
      </v-dropdown>
    </v-level-item>
    <v-level-item v-tooltip="'Close Chat'">
      <v-favicon
        icon="times"
        @click.native="closeWindow"/>
    </v-level-item>
  </div>
</template>
<script>
import ChatEvents from "../../mixins/ChatEvents";
import ChatMenu from "../chat/ChatMenu";
import VDropdown from "../utility/VDropdown";
import VFavicon from "../utility/VFavicon";
import VLevelItem from "../utility/VLevelItem";

export default {
  name: "ChatWindowHeadActions",

  components: {
    ChatMenu,
    VDropdown,
    VFavicon,
    VLevelItem
  },

  mixins: [ChatEvents]
};
</script>
