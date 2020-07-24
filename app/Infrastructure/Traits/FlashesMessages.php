<?php

namespace App\Infrastructure;

trait FlashesMessages
{
  protected function message($level = 'info', $message = null)
  {
      if (session()->has('messages')) {
          $messages = session()->pull('messages');
      }

      $messages[] = $message = ['level' => $level, 'message' => $message];

      session()->flash('messages', $messages);

      return $message;
  }

  protected function messages()
  {
      return self::hasMessages() ? session()->pull('messages') : [];
  }

  protected function hasMessages()
  {
      return session()->has('messages');
  }

  protected function success($message)
  {
      return self::message('success', $message);
  }

  protected function info($message)
  {
      return self::message('info', $message);
  }

  protected function warning($message)
  {
      return self::message('warning', $message);
  }

  protected function danger($message)
  {
      return self::message('danger', $message);
  }
}
