参考文档
https://github.com/coolseven/notes/tree/master/thinkphp-queue

在浏览器中访问 http://your.project.domain/index/index/actionWithHelloJob ,可以看到消息推送成功。
队列配置文件在\application\extra\queue.php

单独执行一次
queue:work 命令

work 命令： 该命令将启动一个 work 进程来处理消息队列。

php think queue:work --queue helloJobQueue

驻留
php think queue:work --daemon --queue helloJobQueue

queue:listen 命令

listen 命令： 该命令将会创建一个 listen 父进程 ，然后由父进程通过 proc_open(‘php think queue:work’) 的方式来创建一个work 子 进程来处理消息队列，且限制该work进程的执行时间。
php think queue:listen --queue helloJobQueue


- Work 模式

  ```bash
  php think queue:work \
  --daemon            //是否循环执行，如果不加该参数，则该命令处理完下一个消息就退出
  --queue  helloJobQueue  //要处理的队列的名称
  --delay  0 \        //如果本次任务执行抛出异常且任务未被删除时，设置其下次执行前延迟多少秒,默认为0
  --force  \          //系统处于维护状态时是否仍然处理任务，并未找到相关说明
  --memory 128 \      //该进程允许使用的内存上限，以 M 为单位
  --sleep  3 \        //如果队列中无任务，则sleep多少秒后重新检查(work+daemon模式)或者退出(listen或非daemon模式)
  --tries  2          //如果任务已经超过尝试次数上限，则触发‘任务尝试次数超限’事件，默认为0
  ```

- Listen 模式

  ```bash
  php think queue:listen \
  --queue  helloJobQueue \   //监听的队列的名称
  --delay  0 \         //如果本次任务执行抛出异常且任务未被删除时，设置其下次执行前延迟多少秒,默认为0
  --memory 128 \       //该进程允许使用的内存上限，以 M 为单位
  --sleep  3 \         //如果队列中无任务，则多长时间后重新检查，daemon模式下有效
  --tries  0 \         //如果任务已经超过重发次数上限，则进入失败处理逻辑，默认为0
  --timeout 60         //创建的work子进程的允许执行的最长时间，以秒为单位
  ```

  可以看到 listen 模式下，不包含 `--deamon` 参数，原因下面会说明
