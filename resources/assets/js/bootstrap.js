import App from "./components/App";
import AdminView from "./views/admin/AdminView";
import FriendRequestsView from "./views/FriendRequestsView";
import MessagesView from "./views/MessagesView";
import NotificationsView from "./views/NotificationsView";
import ProfileView from "./views/ProfileView";
import ThreadView from "./views/ThreadView";
import ThreadsView from "./views/ThreadsView";
import Tooltips from "./directives/index";
import Echo from "laravel-echo";
import InstantSearch from "vue-instantsearch";
import Pusher from "pusher-js";
import Vue from "vue";

Vue.config.ignoredElements = ["trix-editor"];
Vue.component("app", App);
Vue.component("admin-view", AdminView);
Vue.component("friend-requests-view", FriendRequestsView);
Vue.component("messages-view", MessagesView);
Vue.component("notifications-view", NotificationsView);
Vue.component("profile-view", ProfileView);
Vue.component("thread-view", ThreadView);
Vue.component("threads-view", ThreadsView);
Vue.use(InstantSearch);
Vue.use(Tooltips);
Vue.prototype.$echo = new Echo({
  broadcaster: "pusher",
  key: process.env.MIX_PUSHER_APP_KEY,
  cluster: "eu",
  encrypted: true,
  enabledTransports: ["ws", "wss"]
});
