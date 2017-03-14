<?php


namespace app\events\news;


interface NewsEventsInterface
{
  const EVENT_ON_NEW_ARTICLE_ADDED = 'onArticleCreate';
  const EVENT_ON_ARTICLE_DELETED = 'onArticleDelete';
  const EVENT_ON_ARTICLE_PUBLISHED = 'onArticlePublish';
  const EVENT_ON_TITLE_CHANGED = 'onTitleChange';
  const EVENT_ON_DESCRIPTION_CHANGED = 'onDescriptionChange';
  const EVENT_ON_CONTENT_CHANGED = 'onContentChange';
  const EVENT_ON_PREVIEW_CHANGED = 'onPreviewChange';
}