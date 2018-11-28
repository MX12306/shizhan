/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : web

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-11-28 21:42:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `sx_answer`
-- ----------------------------
DROP TABLE IF EXISTS `sx_answer`;
CREATE TABLE `sx_answer` (
  `id` int(8) NOT NULL AUTO_INCREMENT COMMENT '题目ID',
  `cid` int(11) NOT NULL COMMENT '题目分类ID',
  `name` varchar(100) NOT NULL COMMENT '题目名称',
  `content` text NOT NULL COMMENT '题目内容',
  `flag` varchar(255) NOT NULL COMMENT '答案',
  `score` int(7) NOT NULL DEFAULT '0' COMMENT '分值',
  `visible` int(1) NOT NULL DEFAULT '1' COMMENT '可见:0否1可',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `cid` (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=93 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sx_answer
-- ----------------------------
INSERT INTO `sx_answer` VALUES ('51', '5', '1.1 ARP扫描渗透测试', '任务1. ARP扫描渗透测试（100分）\r\n任务环境说明：\r\n服务器场景：server2003（用户名：administrator；密码：空）\r\n服务器场景操作系统：Windows server2003\r\n\r\n1.通过本地PC中渗透测试平台BT5对服务器场景server2003进行ARP扫描渗透测试（使用工具arping，发送请求数据包数量为5个），并将该操作使用命令中固定不变的字符串作为Flag提交；（16分）', 'arping -c 5', '16', '1');
INSERT INTO `sx_answer` VALUES ('52', '5', '1.2 ARP扫描渗透测试', '2.通过本地PC中渗透测试平台BT5对服务器场景server2003进行ARP扫描渗透测试（使用工具arping，发送请求数据包数量为5个），并将该操作结果的最后1行，从左边数第2个数字作为Flag提交；（17分）', '5', '17', '1');
INSERT INTO `sx_answer` VALUES ('53', '5', '1.3 ARP扫描渗透测试', '3. 通过本地PC中渗透测试平台BT5对服务器场景server2003行ARP扫描渗透测试（使用工具Metasploit中arp_sweep模块），并将工具Metasploit中arp_sweep模块存放路径字符串作为Flag（形式：字符串1/字符串2/字符串3/…/字符串n）提交；（16分）', 'auxiliary/scanner/discovery/arp_sweep', '16', '1');
INSERT INTO `sx_answer` VALUES ('54', '5', '1.4 ARP扫描渗透测试', '4. 通过本地PC中渗透测试平台BT5对服务器场景server2003进行ARP扫描渗透测试（使用工具Metasploit中arp_sweep模块），假设目标服务器场景CentOS5.5在线，请将工具Metasploit中arp_sweep模块运行显示结果的最后1行的最后1个单词作为Flag提交；（17分）', 'completed', '17', '1');
INSERT INTO `sx_answer` VALUES ('56', '5', '1.5 ARP扫描渗透测试', '5. 通过本地PC中渗透测试平台BT5对服务器场景server2003进行ARP扫描渗透测试（使用工具Metasploit中arp_sweep模块），假设目标服务器场景CentOS5.5在线，请将工具Metasploit中arp_sweep模块运行显示结果的第1行出现的IP地址右边的第1个单词作为Flag提交；（16分）', 'appears', '16', '1');
INSERT INTO `sx_answer` VALUES ('57', '5', '1.6 ARP扫描渗透测试', '6. 通过本地PC中渗透测试平台BT5对服务器场景server2003进行ARP扫描渗透测试（使用工具Metasploit中arp_sweep模块），假设目标服务器场景CentOS5.5在线，请将工具Metasploit中arp_sweep模块的运行命令字符串作为Flag提交；（18分）', 'run', '18', '1');
INSERT INTO `sx_answer` VALUES ('58', '5', '2.1漏洞扫描与利用', '任务环境说明：\r\n服务器场景：server2003（用户名：administrator；密码：空）\r\n服务器场景操作系统：Windows server2003\r\n\r\n1.通过本地PC中渗透测试平台Kali对服务器场景server2003以半开放式不进行ping的扫描方式并配合a，要求扫描信息输出格式为xml文件格式，从生成扫描结果获取局域网（例如172.16.101.0/24）中存活靶机，以xml格式向指定文件输出信息（使用工具NMAP，使用必须要使用的参数），并将该操作使用命令中必须要使用的参数作为FLAG提交；（12分）', '-sS -A -oX', '12', '1');
INSERT INTO `sx_answer` VALUES ('59', '5', '2.2漏洞扫描与利用', '2.根据第一题扫描的回显信息分析靶机操作系统版本信息，将操作系统版本信息作为FLAG提交；（9分）', 'Microsoft Windows XP|2003', '9', '1');
INSERT INTO `sx_answer` VALUES ('60', '5', '2.3漏洞扫描与利用', '3.根据第一题扫描的回显信息分析靶机服务开放端口，分析开放的服务，并将共享服务的开放状态作为FLAG提交；（9分）', 'open', '9', '1');
INSERT INTO `sx_answer` VALUES ('61', '5', '2.4漏洞扫描与利用', '4.在本地PC的渗透测试平台Kali中，使用命令初始化msf数据库，并将使用的命令作为FLAG提交；（10分）', 'msfdb init', '9', '1');
INSERT INTO `sx_answer` VALUES ('62', '5', '2.4漏洞扫描与利用', '5.在本地PC的渗透测试平台Kali中，打开msf，使用db_import将扫描结果导入到数据库中，并查看导入的数据，将查看导入的数据要使用的命令作为FLAG提交；（10分）', 'hosts', '10', '1');
INSERT INTO `sx_answer` VALUES ('63', '5', '2.6漏洞扫描与利用', '6.在msfconsole使用search命令搜索MS08067漏洞攻击程序，并将回显结果中的漏洞时间作为FLAG提交；（10分）', '2008-10-28', '10', '1');
INSERT INTO `sx_answer` VALUES ('64', '5', '2.7漏洞扫描与利用', '7.在msfconsole中利用MS08067漏洞攻击模块，将调用此模块的命令作为FLAG提交；（10分）', 'use exploit/windows/smb/ms08_067_netapi', '10', '1');
INSERT INTO `sx_answer` VALUES ('65', '5', '2.8漏洞扫描与利用', '8.在上一步的基础上查看需要设置的选项，并将回显中需设置的选项名作为FLAG提交；（10分）', 'RHOST', '10', '1');
INSERT INTO `sx_answer` VALUES ('66', '5', '2.9漏洞扫描与利用', '9.使用set命令设置目标IP（在第8步的基础上），并检测漏洞是否存在，将回显结果中最后四个单词作为FLAG提交；（13分）', 'no session was created', '13', '1');
INSERT INTO `sx_answer` VALUES ('67', '5', '2.10漏洞扫描与利用', '10.查看可选项中存在此漏洞的系统版本，判断该靶机是否有此漏洞，若有，将存在此漏洞的系统版本序号作为FLAG提交，否则FLAG为none。（7分）', 'none', '7', '1');
INSERT INTO `sx_answer` VALUES ('68', '5', '3.1MSSQL数据库渗透测试', '任务环境说明：\r\n服务器场景：server2003（用户名：administrator；密码：空）\r\n服务器场景操作系统：Windows server2003\r\n<h3>由于靶机原因,此题需要先给靶机安装SP4补丁包,靶机信息请到赛题底部查看</h3>\r\n<h3>补丁文件在 C:\\SQL2KSP4 文件夹中</h3>\r\n1.在本地PC渗透测试平台BT5中使用zenmap工具扫描服务器场景server2003所在网段(例如：172.16.101.0/24)范围内存活的主机IP地址和指定开放的1433、3306、80端口。并将该操作使用的命令中必须要使用的字符串作为FLAG提交；（10分）\r\n\r\n', '-p 1433,3306,80', '10', '1');
INSERT INTO `sx_answer` VALUES ('69', '5', '3.2MSSQL数据库渗透测试', '2.通过本地PC中渗透测试平台BT5对服务器场景server2003进行系统服务及版本扫描渗透测试，并将该操作显示结果中数据库服务对应的服务端口信息作为FLAG提交；（10分）', '1433', '10', '1');
INSERT INTO `sx_answer` VALUES ('70', '5', '3.3MSSQL数据库渗透测试', '3.在本地PC渗透测试平台BT5中使用MSF中模块对其爆破，使用search命令，并将扫描弱口令模块的名称作为FLAG提交；（10分）', 'mssql_login', '10', '1');
INSERT INTO `sx_answer` VALUES ('71', '5', '3.4MSSQL数据库渗透测试', '4.在上一题的基础上使用命令调用该模块，并查看需要配置的信息（使用show options命令），将回显中需要配置的目标地址,密码使用的猜解字典,线程,账户配置参数的字段作为FLAG提交（之间以英文逗号分隔，例hello,test，..,..）；（10分）', 'RHOSTS,PASS_FILE,THREADS,USERNAME', '10', '1');
INSERT INTO `sx_answer` VALUES ('72', '5', '3.5MSSQL数据库渗透测试', '5.在msf模块中配置目标靶机IP地址，将配置命令中的前两个单词作为FLAG提交；（10分）', 'set RHOSTS', '10', '1');
INSERT INTO `sx_answer` VALUES ('73', '5', '3.6MSSQL数据库渗透测试', '6.在msf模块中指定密码字典，字典路径为/root/2.txt爆破获取密码并将得到的密码作为FLAG提交；（14分）\r\n\r\n<h3>由于环境问题没有提供字典,请使用 crunch 4 4 0123 -o /root/2.txt 生成字典,在赛场上的攻击机是会提供的</h3>', '0101', '14', '1');
INSERT INTO `sx_answer` VALUES ('74', '5', '3.7MSSQL数据库渗透测试', '7.在msf模块中切换新的渗透模块，对服务器场景server2003进行数据库服务扩展存储过程进行利用，将调用该模块的命令作为FLAG提交；（14分）', 'use auxiliary/admin/mssql/mssql_exec', '14', '1');
INSERT INTO `sx_answer` VALUES ('75', '5', '3.8MSSQL数据库渗透测试', '8.在上一题的基础上，使用第6题获取到的密码并进行提权，同时使用show options命令查看需要的配置，并配置CMD参数来查看系统用户，将配置的命令作为FLAG提交；（14分）', 'set CMD cmd.exe /c net user', '14', '1');
INSERT INTO `sx_answer` VALUES ('76', '5', '3.9MSSQL数据库渗透测试', '9.在利用msf模块获取系统权限并查看目标系统的（来宾）用户，并将该用户作为FLAG提交。（8分）', 'Guest', '8', '1');
INSERT INTO `sx_answer` VALUES ('77', '5', '4.1Windows操作系统渗透测试', '任务环境说明：\r\n服务器场景：PYsystem4\r\n服务器场景操作系统：Windows（版本不详）\r\n\r\n1.通过本地PC中渗透测试平台Kali对服务器场景PYsystem4进行操作系统扫描渗透测试，并将该操作显示结果“Running：”之后的字符串作为FLAG提交；（6分）', 'Microsoft Windows XP|2003', '6', '1');
INSERT INTO `sx_answer` VALUES ('78', '5', '4.2Windows操作系统渗透测试', '2.通过本地PC中渗透测试平台Kali对服务器场景PYsystem4进行系统服务及版本扫描渗透测试，并将该操作显示结果中445端口对应的服务版本信息字符串作为FLAG提交；（6分）', 'Microsoft Windows XP microsoft-ds', '6', '1');
INSERT INTO `sx_answer` VALUES ('79', '5', '4.3Windows操作系统渗透测试', '3.通过本地PC中渗透测试平台Kali对服务器场景PYsystem4进行渗透测试，将该场景网络连接信息中的DNS信息作为FLAG提交;(例如114.114.114.114)（13分）', '1.1.1.1', '13', '1');
INSERT INTO `sx_answer` VALUES ('80', '5', '4.4Windows操作系统渗透测试', '4.通过本地PC中渗透测试平台Kali对服务器场景PYsystem4进行渗透测试，将该场景桌面上111文件夹中唯一一个后缀为.docx文件的文件名称作为FLAG提交；（14分）', 'jimiwenjian', '14', '1');
INSERT INTO `sx_answer` VALUES ('82', '5', '4.5Windows操作系统渗透测试', '5.通过本地PC中渗透测试平台Kali对服务器场景PYsystem4进行渗透测试，将该场景桌面上111文件夹中唯一一个后缀为.docx文件的文档内容作为FLAG提交；（16分）', 'nigediaomao', '16', '1');
INSERT INTO `sx_answer` VALUES ('83', '5', '4.6Windows操作系统渗透测试', '6.通过本地PC中渗透测试平台Kali对服务器场景PYsystem4进行渗透测试，将该场景桌面上222文件夹中唯一一个图片中的英文单词作为FLAG提交；（15分）', 'diaomaogeni', '15', '1');
INSERT INTO `sx_answer` VALUES ('84', '5', '4.7Windows操作系统渗透测试', '7.通过本地PC中渗透测试平台Kali对服务器场景PYsystem4进行渗透测试，将该场景中的当前最高账户管理员(Administrator)的密码作为FLAG提交；（10分）\r\n \r\n<h1>提示：john </h1>', '1123', '10', '1');
INSERT INTO `sx_answer` VALUES ('85', '5', '4.8Windows操作系统渗透测试', '8.通过本地PC中渗透测试平台Kali对服务器场景PYsystem4进行渗透测试，将该场景中回收站内文件的文档内容作为FLAG提交。（20分）', '1834833515', '20', '1');
INSERT INTO `sx_answer` VALUES ('88', '5', '5.1IPSec VPN安全攻防', '服务器场景名称：WebServ2003\r\n服务器场景安全操作系统：Microsoft Windows2003 Server\r\n服务器场景安装中间件：Apache2.2；\r\n服务器场景安装Web开发环境：Php6；\r\n服务器场景安装数据库：Microsoft SqlServer2000；\r\n服务器场景用户名：administrator，密码：空\r\n\r\n1.PC2（虚拟机：Backtrack5）打开Wireshark工具，监听PC2（虚拟机：WindowsXP）通过InternetExplorer访问服务器场景WebServ2003的login.php页面，通过该页面对Web站点进行登录，同时使用PC2（虚拟机：Backtrack5）的Wireshark工具对HTTP请求数据包进行分析，将该数据包中存放用户名的变量名和存放密码的变量名联合作为Flag（形式：存放用户名的变量名&存放密码的变量名）提交；(10分)', 'usernm&passwd', '10', '1');
INSERT INTO `sx_answer` VALUES ('89', '5', '5.2IPSec VPN安全攻防', '2.在PC2（虚拟机：WindowsXP）和WebServ2003服务器场景之间通过IPSec技术建立安全VPN，阻止PC2（虚拟机：Backtrack5）通过Wireshark工具对本任务上题的HTTP请求数据包进行分析；PC2（虚拟机：WindowsXP）通过Ping工具测试WebServ2003服务器场景的连通性，将回显的第1个数据包Ping工具的打印结果作为Flag提交；（20分）', 'Negotiating IP Security.', '20', '1');
INSERT INTO `sx_answer` VALUES ('90', '5', '5.3IPSec VPN安全攻防', '3.在PC2（虚拟机：WindowsXP）和WebServ2003服务器场景之间通过IPSec技术建立安全VPN 的条件下：\r\nPC2（虚拟机：Backtrack5）打开Wireshark工具，监听PC2（虚拟机：WindowsXP）通过InternetExplorer访问服务器场景WebServ2003的login.php页面，通过该页面对Web站点进行登录，同时使用PC2（虚拟机：Backtrack5）的Wireshark工具对HTTP请求数据包进行分析，将Wireshark工具中显示该流量的协议名称作为Flag提交 (10分)', 'ESP', '11', '1');
INSERT INTO `sx_answer` VALUES ('91', '5', '5.4IPSec VPN安全攻防', '4.在PC2（虚拟机：WindowsXP）和WebServ2003服务器场景之间通过IPSec技术建立安全VPN 的条件下：\r\nPC2（虚拟机：Backtrack5）打开Wireshark工具，监听PC2（虚拟机：WindowsXP）通过Ping工具测试到服务器场景WebServ2003的连通性，在Ping工具中指定ICMP请求数据包的大小为128byte，同时使用PC2（虚拟机：Backtrack5）的Wireshark工具对加密后的该数据包进行分析，将Wireshark工具中显示该数据包的长度作为Flag提交（30分）', '206', '30', '1');
INSERT INTO `sx_answer` VALUES ('92', '5', '5.5IPSec VPN安全攻防', '5.在PC2（虚拟机：WindowsXP）和WebServ2003服务器场景之间通过IPSec技术建立安全VPN 的条件下：\r\nPC2（虚拟机：Backtrack5）打开Wireshark工具，监听PC2（虚拟机：WindowsXP）通过Ping工具测试到服务器场景WebServ2003的连通性，在Ping工具中指定ICMP请求数据包的大小为128byte，数量为100；同时使用PC2（虚拟机：Backtrack5）的Wireshark工具对加密后的该数据包进行分析，将Wireshark工具中显示的最后一个加密后的请求数据包和第一个加密后的请求数据包的序列号之差作为Flag提交 （30分）', '99', '30', '1');

-- ----------------------------
-- Table structure for `sx_answer_cls`
-- ----------------------------
DROP TABLE IF EXISTS `sx_answer_cls`;
CREATE TABLE `sx_answer_cls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sx_answer_cls
-- ----------------------------
INSERT INTO `sx_answer_cls` VALUES ('5', '2018网络空间安全样题-1');

-- ----------------------------
-- Table structure for `sx_config`
-- ----------------------------
DROP TABLE IF EXISTS `sx_config`;
CREATE TABLE `sx_config` (
  `keys` varchar(255) NOT NULL COMMENT '设置名',
  `value` text NOT NULL COMMENT '设置值',
  `ms` varchar(255) NOT NULL,
  PRIMARY KEY (`keys`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sx_config
-- ----------------------------
INSERT INTO `sx_config` VALUES ('announcement', '欢迎来到网络安全竞赛答题平台！\r\n请遵守相关规定,请勿对本平台进行恶意攻击!\r\n1.请勿对题目进行破坏。\r\n2.请勿对本平台展开攻击,如果你发现漏洞请联系管理员修复。\r\n本赛场计时器与实际时间有1-3秒的误差,请选手抓紧时间做题。', '比赛的公告');
INSERT INTO `sx_config` VALUES ('title', '网络安全竞赛答题平台', '平台的标题');
INSERT INTO `sx_config` VALUES ('start_time', '1543302466', '开始的时间戳');
INSERT INTO `sx_config` VALUES ('stop_time', '1543308466', '结束的时间戳');
INSERT INTO `sx_config` VALUES ('open_time', '0', '开启或关闭比赛,如果为1 则开启比赛计时');
INSERT INTO `sx_config` VALUES ('tips', '', '登录和注册页面的右侧代码');
INSERT INTO `sx_config` VALUES ('timu', '5', '输入cls表中题目的ID调出题目,如果为空则默认显示公告');

-- ----------------------------
-- Table structure for `sx_log`
-- ----------------------------
DROP TABLE IF EXISTS `sx_log`;
CREATE TABLE `sx_log` (
  `id` int(8) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uid` int(8) NOT NULL COMMENT '选手id',
  `aid` int(8) NOT NULL COMMENT '题目id',
  `cid` int(11) NOT NULL,
  `answer` text NOT NULL COMMENT '答案',
  `an_time` time NOT NULL COMMENT '答题时间',
  `yn` int(1) NOT NULL DEFAULT '0' COMMENT '是否正确:1得0没',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sx_log
-- ----------------------------

-- ----------------------------
-- Table structure for `sx_score`
-- ----------------------------
DROP TABLE IF EXISTS `sx_score`;
CREATE TABLE `sx_score` (
  `id` int(8) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uid` int(8) NOT NULL COMMENT '选手ID',
  `aid` int(8) NOT NULL COMMENT '得分题目id',
  `cid` int(11) NOT NULL,
  `an_time` time NOT NULL COMMENT '答题时间',
  `score` int(7) NOT NULL COMMENT '分值',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sx_score
-- ----------------------------

-- ----------------------------
-- Table structure for `sx_user`
-- ----------------------------
DROP TABLE IF EXISTS `sx_user`;
CREATE TABLE `sx_user` (
  `id` int(8) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `user` varchar(16) NOT NULL COMMENT '用户名',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `login_ip` varchar(15) NOT NULL DEFAULT '0.0.0.0' COMMENT '最后登录IP',
  `login_time` varchar(11) NOT NULL COMMENT '最后登录时间',
  `isadmin` int(1) NOT NULL DEFAULT '0',
  `info` text,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `user` (`user`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sx_user
-- ----------------------------
INSERT INTO `sx_user` VALUES ('1', 'admin', 'admin', '0.0.0.0', '0', '1', '');
