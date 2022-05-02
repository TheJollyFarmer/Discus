import { getKeys } from "../utils/helpers";

export default {
  threads(thread) {
    return {
      id: thread.id,
      channel: thread.channel_id,
      user: thread.creator.id,
      slug: thread.slug,
      channelSlug: thread.channel.slug,
      channelName: thread.channel.name,
      title: thread.title,
      username: thread.creator.username,
      body: thread.body,
      avatar: thread.creator.avatar_path,
      comments: thread.replies_count,
      isBest: thread.best_reply_id,
      isLocked: thread.locked,
      isPinned: thread.pinned,
      isSubscribed: thread.isSubscribedTo,
      hasUpdates: thread.hasUpdatesFor,
      visits: thread.visits,
      created: thread.created_at,
      showContent: false
    };
  },

  channels(channel) {
    return {
      name: channel.name,
      slug: channel.slug,
      description: channel.description,
      threads: channel.threadsCount
    };
  },

  comments(comment) {
    return {
      id: comment.id,
      parent: comment.parent_id,
      thread: comment.thread_id,
      user: comment.user_id,
      username: comment.owner.name,
      avatar: comment.owner.avatar_path,
      body: comment.body,
      favourites: comment.favourites_total,
      isFavourited: comment.isFavourited,
      created: comment.created_at,
      replies: comment.replies !== undefined ? getKeys(comment.replies) : [],
      showContent: true
    };
  },

  paginator(paginator) {
    return {
      current: paginator.current_page,
      total: paginator.last_page,
      perPage: paginator.per_page,
      totalComments: paginator.total
    };
  },

  messages(message) {
    return {
      id: message.latest_message.id,
      group: message.id,
      user: message.latest_message.user.username,
      avatar: message.latest_message.user.avatar_path,
      body: message.latest_message.message,
      created: message.latest_message.created_at,
      type: message.type,
      users: getKeys(message.users),
      read: null
    };
  },

  friendRequests(friendRequest) {
    return {
      id: friendRequest.pivot.id,
      user: friendRequest.username,
      avatar: friendRequest.avatar_path,
      created: friendRequest.pivot.created_at
    };
  },

  notifications(notification) {
    return {
      id: notification.id,
      reply: notification.data.reply_id,
      thread: notification.data.thread_id,
      channel: notification.data.channel,
      user: notification.data.user,
      title: notification.data.thread_title,
      body: notification.data.reply_body,
      read: notification.read_at,
      avatar: notification.data.avatar,
      type: notification.type,
      created: notification.created_at,
      slug: notification.data.slug
    };
  },

  friends(friend) {
    return {
      id: friend.id,
      user: friend.username,
      avatar: friend.avatar_path
    };
  },

  groups(group) {
    return {
      id: group.id,
      name: group.name,
      type: group.type,
      display: true
    };
  },

  groupUsers(user) {
    return {
      id: user.id,
      user: user.username
    };
  },

  conversations(message) {
    return {
      id: message.id,
      body: message.message,
      created: message.created_at,
      group: message.group_id,
      user: message.user.username,
      avatar: message.user.avatar_path
    };
  },

  activity: {
    favourites(favourite) {
      return {
        avatar: favourite.favouritedModel.owner.avatar_path,
        title: favourite.favouritedModel.thread.title,
        username: favourite.favouritedModel.thread.creator.username,
        body: favourite.favouritedModel.body,
        slug: favourite.favouritedModel.thread.slug,
        channelSlug: favourite.favouritedModel.thread.channel.slug
      };
    },

    replies(reply) {
      return {
        avatar: reply.subject.owner.avatar_path,
        title: reply.subject.thread.title,
        username: reply.subject.thread.creator.username,
        body: reply.subject.body,
        favourites: reply.subject.favourites_total,
        isBest: reply.subject.isBest,
        xp: reply.subject.xp,
        slug: reply.subject.thread.slug,
        channelSlug: reply.subject.thread.channel.slug
      };
    },

    threads(thread) {
      return {
        avatar: thread.subject.creator.avatar_path,
        title: thread.subject.title,
        username: thread.subject.creator.username,
        body: thread.subject.body,
        comments: thread.subject.replies_count,
        visits: thread.subject.visits,
        slug: thread.subject.slug,
        channelSlug: thread.subject.channel.slug
      };
    }
  }
};
