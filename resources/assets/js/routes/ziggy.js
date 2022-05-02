var Ziggy = {
  namedRoutes: {
    "debugbar.openhandler": {
      uri: "_debugbar/open",
      methods: ["GET", "HEAD"],
      domain: null
    },
    "debugbar.clockwork": {
      uri: "_debugbar/clockwork/{id}",
      methods: ["GET", "HEAD"],
      domain: null
    },
    "debugbar.assets.css": {
      uri: "_debugbar/assets/stylesheets",
      methods: ["GET", "HEAD"],
      domain: null
    },
    "debugbar.assets.js": {
      uri: "_debugbar/assets/javascript",
      methods: ["GET", "HEAD"],
      domain: null
    },
    "debugbar.cache.delete": {
      uri: "_debugbar/cache/{key}/{tags?}",
      methods: ["DELETE"],
      domain: null
    },
    login: { uri: "login", methods: ["GET", "HEAD"], domain: null },
    logout: { uri: "logout", methods: ["POST"], domain: null },
    register: { uri: "register", methods: ["GET", "HEAD"], domain: null },
    "password.request": {
      uri: "password/reset",
      methods: ["GET", "HEAD"],
      domain: null
    },
    "password.email": {
      uri: "password/email",
      methods: ["POST"],
      domain: null
    },
    "password.reset": {
      uri: "password/reset/{token}",
      methods: ["GET", "HEAD"],
      domain: null
    },
    home: { uri: "/", methods: ["GET", "HEAD"], domain: null },
    "threads.index": {
      uri: "threads/{channel?}",
      methods: ["GET", "HEAD"],
      domain: null
    },
    "threads.create": {
      uri: "threads/create",
      methods: ["GET", "HEAD"],
      domain: null
    },
    "threads.store": { uri: "threads", methods: ["POST"], domain: null },
    "threads.show": {
      uri: "threads/{channel}/{thread?}",
      methods: ["GET", "HEAD"],
      domain: null
    },
    "threads.update": {
      uri: "threads/{channel}/{thread}",
      methods: ["PATCH"],
      domain: null
    },
    "threads.destroy": {
      uri: "threads/{channel}/{thread}",
      methods: ["DELETE"],
      domain: null
    },
    "locked-threads.store": {
      uri: "locked-threads/{thread}",
      methods: ["POST"],
      domain: null
    },
    "locked-threads.destroy": {
      uri: "locked-threads/{thread}",
      methods: ["DELETE"],
      domain: null
    },
    "thread-subscriptions.store": {
      uri: "threads/{channel}/{thread}/subscriptions",
      methods: ["POST"],
      domain: null
    },
    "thread-subscriptions.destroy": {
      uri: "threads/{channel}/{thread}/subscriptions",
      methods: ["DELETE"],
      domain: null
    },
    "replies.index": {
      uri: "threads/{channel}/{thread}/replies",
      methods: ["GET", "HEAD"],
      domain: null
    },
    "replies.store": {
      uri: "threads/{channel}/{thread}/replies",
      methods: ["POST"],
      domain: null
    },
    "replies.show": {
      uri: "replies/{reply}",
      methods: ["GET", "HEAD"],
      domain: null
    },
    "replies.update": {
      uri: "replies/{reply}",
      methods: ["PATCH"],
      domain: null
    },
    "replies.destroy": {
      uri: "replies/{reply}",
      methods: ["DELETE"],
      domain: null
    },
    "best-comments.store": {
      uri: "replies/{reply}/best",
      methods: ["POST"],
      domain: null
    },
    "best-comments.update": {
      uri: "replies/{reply}/best",
      methods: ["PATCH"],
      domain: null
    },
    "favourites.store": {
      uri: "replies/{reply}/favourites",
      methods: ["POST"],
      domain: null
    },
    "favourites.destroy": {
      uri: "replies/{reply}/favourites",
      methods: ["DELETE"],
      domain: null
    },
    "profiles.activities": {
      uri: "profiles/{user}/activities",
      methods: ["GET", "HEAD"],
      domain: null
    },
    "profiles.show": {
      uri: "profiles/{user}",
      methods: ["GET", "HEAD"],
      domain: null
    },
    settings: { uri: "settings", methods: ["GET", "HEAD"], domain: null },
    messages: { uri: "messages", methods: ["GET", "HEAD"], domain: null },
    "friendships.index": {
      uri: "profiles/{user}/friendships",
      methods: ["GET", "HEAD"],
      domain: null
    },
    "friends.requests.index": {
      uri: "users/{user}/friends/requests",
      methods: ["GET", "HEAD"],
      domain: null
    },
    "friendships.show": {
      uri: "profiles/{user}/friendships/friend",
      methods: ["GET", "HEAD"],
      domain: null
    },
    "friendships.store": {
      uri: "profiles/{user}/friendships",
      methods: ["POST"],
      domain: null
    },
    "friendships.update": {
      uri: "profiles/friendships/{friendship}",
      methods: ["PATCH"],
      domain: null
    },
    "friendships.destroy": {
      uri: "profiles/friendships/{friendship}",
      methods: ["DELETE"],
      domain: null
    },
    "notifications.index": {
      uri: "profiles/{user}/notifications",
      methods: ["GET", "HEAD"],
      domain: null
    },
    "notifications.update": {
      uri: "profiles/{user}/notifications/{notification?}",
      methods: ["PATCH"],
      domain: null
    },
    "notifications.destroy": {
      uri: "profiles/{user}/notifications",
      methods: ["DELETE"],
      domain: null
    },
    "groups.index": { uri: "groups", methods: ["GET", "HEAD"], domain: null },
    "groups.create": {
      uri: "groups/create",
      methods: ["GET", "HEAD"],
      domain: null
    },
    "groups.store": { uri: "groups", methods: ["POST"], domain: null },
    "groups.show": {
      uri: "groups/{group}",
      methods: ["GET", "HEAD"],
      domain: null
    },
    "groups.edit": {
      uri: "groups/{group}/edit",
      methods: ["GET", "HEAD"],
      domain: null
    },
    "groups.update": {
      uri: "groups/{group}",
      methods: ["PUT", "PATCH"],
      domain: null
    },
    "groups.destroy": {
      uri: "groups/{group}",
      methods: ["DELETE"],
      domain: null
    },
    "conversations.index": {
      uri: "conversations",
      methods: ["GET", "HEAD"],
      domain: null
    },
    "conversations.create": {
      uri: "conversations/create",
      methods: ["GET", "HEAD"],
      domain: null
    },
    "conversations.store": {
      uri: "conversations",
      methods: ["POST"],
      domain: null
    },
    "conversations.show": {
      uri: "conversations/{conversation}",
      methods: ["GET", "HEAD"],
      domain: null
    },
    "conversations.edit": {
      uri: "conversations/{conversation}/edit",
      methods: ["GET", "HEAD"],
      domain: null
    },
    "conversations.update": {
      uri: "conversations/{conversation}",
      methods: ["PUT", "PATCH"],
      domain: null
    },
    "conversations.destroy": {
      uri: "conversations/{conversation}",
      methods: ["DELETE"],
      domain: null
    },
    "register.verify": {
      uri: "register/verify",
      methods: ["GET", "HEAD"],
      domain: null
    },
    "admin.index": {
      uri: "admin",
      methods: ["GET", "HEAD"],
      domain: null
    },
    "admin.channels.store": {
      uri: "admin/channels",
      methods: ["POST"],
      domain: null
    },
    "admin.channels.index": {
      uri: "admin/channels",
      methods: ["GET", "HEAD"],
      domain: null
    },
    "admin.channels.create": {
      uri: "admin/channels/create",
      methods: ["GET", "HEAD"],
      domain: null
    },
    "admin.channels.edit": {
      uri: "admin/channels/{channel}/edit",
      methods: ["GET", "HEAD"],
      domain: null
    },
    "admin.channels.update": {
      uri: "admin/channels/{channel}",
      methods: ["PATCH"],
      domain: null
    },
    "users.index": { uri: "api/users", methods: ["GET", "HEAD"], domain: null },
    "channels.index": {
      uri: "api/channels",
      methods: ["GET", "HEAD"],
      domain: null
    },
    avatar: { uri: "api/users/{user}/avatar", methods: ["POST"], domain: null }
  },
  baseUrl: "http://forum.test/",
  baseProtocol: "http",
  baseDomain: "forum.test",
  basePort: false,
  defaultParameters: []
};

if (typeof window.Ziggy !== "undefined") {
  for (var name in window.Ziggy.namedRoutes) {
    Ziggy.namedRoutes[name] = window.Ziggy.namedRoutes[name];
  }
}

export { Ziggy };
