# shizhan

#### 项目介绍

灵盾网络空间安全竞赛答题平台 - 使用ThinkPHP5.0+Bootstrap3编写,此平台用于模拟网络空间安全赛项的第一阶段。

### 演示站点

> test.ld80.cn

#### 项目截图
前端界面
![输入图片说明](https://gitee.com/uploads/images/2019/0405/144406_ee65b732_1270405.png "屏幕截图.png")
![输入图片说明](https://gitee.com/uploads/images/2019/0405/144453_b7c796a3_1270405.png "屏幕截图.png")
后端界面
![输入图片说明](https://gitee.com/uploads/images/2019/0405/144627_df6e2b5b_1270405.png "屏幕截图.png")

#### Docker

 1. 构建镜像

    说明: 平台的管理员账户及密码可在start.sh:7中更改

    shell执行`docker build -t lingdun/shizhan .`来构建docker镜像, 首先你需要保证你已经安装并启动docker

 2. 选择现有镜像

    shell执行`docker pull lingdun/shizhan`来下载docker镜像, 首先你需要保证你已经安装并启动docker

 3. 启动容器
    
    容器内部开放端口有：80、443、3306

    shell执行`docker run -d -p80:80 -v shizhan_sqldb:/var/lib/mysql lingdun/shizhan`
    
 4. 说明
    
    默认mysql账号密码为：root/ld80cn
    
    默认管理员账户密码为： admin/adminadmin

    **数据库密码可在：start.sh:3 进行修改 **

    **管理员密码可在：start.sh:9 进行修改 **

    **修改后进行构建镜像就可以啦**

#### 安装教程 (旧版,已将源代码挪到source目录下)

1. 环境要求:
    >PHP5.6以上
    >mysql 5.5

2. 将网站的运行目录指定到 “public”下，注意目录防跨哦！！

3. 配置重写规则 （列举Nginx重写方式）

    apache服务器已存在.htaccess 只要确保服务器加载了mod_rewrite.so模块即可
    
    如果是nginx服务器 需要添加以下代码到配置文件
    
    在nginx配置文件的  location / {下添加以下内容
    
    ```
                if (!-e $request_filename) {
                    rewrite  ^(.*)$  /index.php?s=/$1  last;
                    break;
                }
    ```

    其它WEB容器详见:https://www.kancloud.cn/manual/thinkphp5/177576

4. 打开网站,根据安装指引 填写数据库信息,管理员信息即可。

### 平台功能

 **前台部分** 

    1. 基本的登录注册功能
    2. 答题功能
    3. 动态排行榜功能
    4. 个人记录和成绩查询功能 

 **后台部分** 

    1. 平台配置
    2. 题目管理
    3. 用户管理