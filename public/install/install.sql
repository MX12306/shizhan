-- --------------------------------------------------------

--
-- 表的结构 `ld_answer`
--

CREATE TABLE IF NOT EXISTS `ld_answer` (
  `id` int(8) NOT NULL AUTO_INCREMENT COMMENT '题目ID',
  `cid` int(11) NOT NULL COMMENT '题目分类ID',
  `name` varchar(100) NOT NULL COMMENT '题目名称',
  `content` text NOT NULL COMMENT '题目内容',
  `flag` varchar(255) NOT NULL COMMENT '答案',
  `score` int(7) NOT NULL DEFAULT '0' COMMENT '分值',
  `visible` int(1) NOT NULL DEFAULT '1' COMMENT '可见:0否1可',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `cid` (`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

--
-- 转存表中的数据 `ld_answer`
--

INSERT INTO `ld_answer` (`id`, `cid`, `name`, `content`, `flag`, `score`, `visible`) VALUES
(1, 1, '1.1  ARP扫描渗透测试（100分）', '服务器场景：serv2003（用户名：administrator；密码：123456）；服务器场景操作系统：Windows serv2003\n\n1.通过本地PC中渗透测试平台BT5对服务器场景serv2003进行ARP扫描渗透测试（使用工具arping，发送请求数据包数量为5个），并将该操作使用命令的参数字符串作为Flag提交；（16分）\n', '-c', 16, 1),
(2, 1, '1.2  ARP扫描渗透测试（100分）', '服务器场景：serv2003（用户名：administrator；密码：123456）；服务器场景操作系统：Windows serv2003\n\n2.通过本地PC中渗透测试平台BT5对服务器场景serv2003进行ARP扫描渗透测试（使用工具arping，发送请求数据包数量为5个），并将该操作结果的最后1行，从左边数第2个数字作为Flag提交；（17分）', '5', 17, 1),
(3, 1, '1.3  ARP扫描渗透测试（100分）', '服务器场景：serv2003（用户名：administrator；密码：123456）；服务器场景操作系统：Windows serv2003\n\n3. 通过本地PC中渗透测试平台BT5对服务器场景serv2003行ARP扫描渗透测试（使用工具Metasploit中arp_sweep模块），并将工具Metasploit中arp_sweep模块存放路径字符串作为Flag（形式：字符串1/字符串2/字符串3/…/字符串n）提交；（16分）', 'auxiliary/scanner/discovery', 16, 1),
(4, 1, '1.4  ARP扫描渗透测试（100分）', '服务器场景：serv2003（用户名：administrator；密码：123456）；服务器场景操作系统：Windows serv2003\n\n4. 通过本地PC中渗透测试平台BT5对服务器场景serv2003进行ARP扫描渗透测试（使用工具Metasploit中arp_sweep模块），假设目标服务器场景serv2003在线，请将工具Metasploit中arp_sweep模块运行显示结果的最后1行的最后1个单词作为Flag提交；（17分）', 'completed', 17, 1),
(5, 1, '1.5  ARP扫描渗透测试（100分）', '服务器场景：serv2003（用户名：administrator；密码：123456）；服务器场景操作系统：Windows serv2003\n\n5. 通过本地PC中渗透测试平台BT5对服务器场景serv2003进行ARP扫描渗透测试（使用工具Metasploit中arp_sweep模块），假设目标服务器场景serv2003在线，请将工具Metasploit中arp_sweep模块运行显示结果的第1行出现的IP地址右边的第1个单词作为Flag提交；（16分）', 'invalid', 16, 1),
(6, 1, '1.6  ARP扫描渗透测试（100分）', '服务器场景：serv2003（用户名：administrator；密码：123456）；服务器场景操作系统：Windows serv2003\n\n6. 通过本地PC中渗透测试平台BT5对服务器场景serv2003进行ARP扫描渗透测试（使用工具Metasploit中arp_sweep模块），假设目标服务器场景serv2003在线，请将工具Metasploit中arp_sweep模块的运行命令字符串作为Flag提交。（18分）', 'run', 18, 1),
(7, 1, '2.1 MSSQL数据库渗透测试（100分）', '服务器场景：serv2003（用户名：administrator；密码：123456）\n服务器场景操作系统：Windows serv2003\n\n1.在本地PC渗透测试平台BT5中使用zenmap工具扫描服务器场景serv2003所在网段(例如：172.16.101.0/24)范围内存活的主机IP地址和指定开放的1433、3306、80端口。并将该操作使用的命令中必须要使用的字符串作为FLAG提交；（10分）', '-p 1433,3306,80', 10, 1),
(8, 1, '2.2 MSSQL数据库渗透测试（100分）', '服务器场景：serv2003（用户名：administrator；密码：123456）\n服务器场景操作系统：Windows serv2003\n\n2.通过本地PC中渗透测试平台BT5对服务器场景serv2003进行系统服务及版本扫描渗透测试，并将该操作显示结果中mssql数据库服务对应的服务端口信息作为FLAG提交；（10分）', '1433/tcp', 10, 1),
(9, 1, '2.3 MSSQL数据库渗透测试（100分）', '服务器场景：serv2003（用户名：administrator；密码：123456）\n服务器场景操作系统：Windows serv2003\n\n3.在本地PC渗透测试平台BT5中使用MSF中模块对其爆破，使用search命令，并将扫描弱口令模块的名称作为FLAG提交；（10分）', 'mssql_login', 10, 1),
(10, 1, '2.4 MSSQL数据库渗透测试（100分）', '服务器场景：serv2003（用户名：administrator；密码：123456）\n服务器场景操作系统：Windows serv2003\n\n4.在上一题的基础上使用命令调用该模块，并查看需要配置的信息（使用show options命令），将回显中需要配置的目标地址,密码使用的猜解字典,线程,账户配置参数的字段作为FLAG提交（之间以英文逗号分隔，例hello,test，..,..）；（10分）', 'RHOSTS,PASS_FILE,THREADS,USERNAME', 10, 1),
(11, 1, '2.5 MSSQL数据库渗透测试（100分）', '服务器场景：serv2003（用户名：administrator；密码：123456）\n服务器场景操作系统：Windows serv2003\n\n5.在msf模块中配置目标靶机IP地址，将配置命令中的前两个单词作为FLAG提交；（10分）', 'set RHOSTS', 10, 1),
(12, 1, '2.6 MSSQL数据库渗透测试（100分）', '服务器场景：serv2003（用户名：administrator；密码：123456）\n服务器场景操作系统：Windows serv2003\n\n6.登陆靶机共享，将共享文件夹password里的passwordList.txt下载到攻击机BT5本地，在msf模块中指定密码字典，字典路径为/root/passwordList.txt爆破获取密码并将得到的密码作为FLAG提交；（14分）\n\npasswordList.txt 的文件内容\n<pre>\nroot\ntoor\npassword\nsa\nsha\nadmin\nmetasploit\n123456\n1213333\n9999777\n12364543\n</pre>', '123456', 14, 1),
(13, 1, '2.7 MSSQL数据库渗透测试（100分）', '服务器场景：serv2003（用户名：administrator；密码：123456）\n服务器场景操作系统：Windows serv2003\n\n7.在msf模块中切换新的渗透模块，对服务器场景serv2003进行数据库服务扩展存储过程进行利用，将调用该模块的命令作为FLAG提交；（14分）', 'use auxiliary/admin/mssql/mssql_exec', 14, 1),
(14, 1, '2.8 MSSQL数据库渗透测试（100分）', '服务器场景：serv2003（用户名：administrator；密码：123456）\n服务器场景操作系统：Windows serv2003\n\n8.在上一题的基础上，使用第6题获取到的密码并进行提权，同时使用show options命令查看需要的配置，并配置CMD参数来查看系统用户，将配置CMD参数的命令作为FLAG提交；（14分）', 'set CMD cmd.exe /c net user', 14, 1),
(15, 1, '2.9 MSSQL数据库渗透测试（100分）', '服务器场景：serv2003（用户名：administrator；密码：123456）\n服务器场景操作系统：Windows serv2003\n\n9.在利用msf模块获取系统权限并查看目标系统的异常（黑客）用户，并将该用户作为FLAG提交。（8分）', 'Hacker', 8, 1),
(16, 1, '3.1 主机发现与信息收集（100分）', '任务环境说明：\n服务器场景：serv2003（用户名：administrator；密码：123456）\n服务器场景操作系统：Windows serv2003\n\n1.通过本地PC中渗透测试平台BT5使用fping对服务器场景serv2003所在网段(例如：172.16.101.0/24)进行主机发现扫描,并将该操作使用的命令中必须要使用的参数作为FLAG提交；（12分）', '-g', 12, 1),
(17, 1, '3.2 主机发现与信息收集（100分）', '任务环境说明：\n服务器场景：serv2003（用户名：administrator；密码：123456）\n服务器场景操作系统：Windows serv2003\n\n2.通过本地PC中渗透测试平台BT5使用genlist对服务器场景serv2003所在网段进行扫描进行主机存活发现, 并将该操作使用的命令中必须要使用的参数作为FLAG提交；（12分）', '-s', 12, 1),
(18, 1, '3.3 主机发现与信息收集（100分）', '任务环境说明：\n服务器场景：serv2003（用户名：administrator；密码：123456）\n服务器场景操作系统：Windows serv2003\n\n3.在通过本地PC中渗透测试平台BT5使用nbtscan对服务器场景serv2003所在网段进搜索扫描，获取目标的MAC地址等信息，并将该操作使用的命令中必须要使用的参数作为FLAG提交；（12分）', '-r', 12, 1),
(19, 1, '3.4 主机发现与信息收集（100分）', '任务环境说明：\n服务器场景：serv2003（用户名：administrator；密码：123456）\n服务器场景操作系统：Windows serv2003\n\n4.假设服务器场景serv2003设置了防火墙无法进行ping检测，通过PC中渗透测试平台BT5使用arping检测主机连通性扫描（发送请求数据包数量为 4个），并将该操作使用的命令中固定不变的字符串作为FLAG提交；（12分）', 'arping -c 4', 12, 1),
(20, 1, '3.5 主机发现与信息收集（100分）', '任务环境说明：\n服务器场景：serv2003（用户名：administrator；密码：123456）\n服务器场景操作系统：Windows serv2003\n\n5.通过本地PC中渗透测试平台BT5使用fping对服务器场景serv2003所在网段进行存活性扫描，且要把最终扫描的存活主机输出到文件ip.txt中，并将该操作使用的命令中必须要使用的参数作为FLAG提交（各参数之间用英文逗号分割，注意题目要求的先后顺序，例a,b）；（12分）', '-g,-a', 12, 1),
(21, 1, '3.6 主机发现与信息收集（100分）', '任务环境说明：\n服务器场景：serv2003（用户名：administrator；密码：123456）\n服务器场景操作系统：Windows serv2003\n\n6.通过本地PC中渗透测试平台BT5使用nbtscan从第5题的ip.txt文件中读取IP扫描主机信息MAC地址等信息，并将该操作使用的命令中固定不变的字符串作为FLAG提交；（12分）', 'nbtscan -f', 12, 1),
(22, 1, '3.7 主机发现与信息收集（100分）', '任务环境说明：\n服务器场景：serv2003（用户名：administrator；密码：123456）\n服务器场景操作系统：Windows serv2003\n\n7.通过本地PC中渗透测试平台BT5使用xprobe2对服务器场景serv2003进行TCP扫描，仅扫描靶机80,3306端口的开放情况(端口之间以英文格式下逗号分隔)，并将该操作使用的命令中固定不变的字符串作为FLAG提交；（12分）', 'xprobe2 -T80,3306', 12, 1),
(23, 1, '3.8 主机发现与信息收集（100分）', '任务环境说明：\n服务器场景：serv2003（用户名：administrator；密码：123456）\n服务器场景操作系统：Windows serv2003\n\n8.通过本地PC中渗透测试平台BT5使用xprobe2对服务器场景serv2003进行UDP扫描，仅扫描靶机161,162端口的开放情况(端口之间以英文格式下逗号分隔)，并将该操作使用的命令中固定不变的字符串作为FLAG提交。（16分）', 'xprobe2 -U161,162', 16, 1),
(24, 1, '4.1 Windows操作系统渗透测试（100分）', '任务环境说明：\n服务器场景：BJST\n服务器场景操作系统：BJST\n\n1.通过本地PC中渗透测试平台Kali对服务器场景BJST进行操作系统扫描渗透测试，并将该操作显示结果“Running：”之后的字符串作为FLAG提交；（6分）', 'Microsoft Windows XP|2003', 6, 1),
(25, 1, '4.2 Windows操作系统渗透测试（100分）', '任务环境说明：\n服务器场景：BJST\n服务器场景操作系统：BJST\n\n2.通过本地PC中渗透测试平台Kali对服务器场景BJST进行系统服务及版本扫描渗透测试，并将该操作显示结果中445端口对应的服务版本信息字符串作为FLAG提交；（6分）', 'Microsoft Windows XP microsoft-ds', 6, 1),
(26, 1, '4.3 Windows操作系统渗透测试（100分）', '任务环境说明：\n服务器场景：BJST\n服务器场景操作系统：BJST\n\n3.通过本地PC中渗透测试平台Kali对服务器场景BJST进行渗透测试，将该场景网络连接信息中的DNS信息作为FLAG提交;(例如114.114.114.114)（13分）', '12.23.34.45', 13, 1),
(27, 1, '4.4 Windows操作系统渗透测试（100分）', '任务环境说明：\n服务器场景：BJST\n服务器场景操作系统：BJST\n\n4.通过本地PC中渗透测试平台Kali对服务器场景BJST进行渗透测试，将该场景桌面上111文件夹中唯一一个后缀为.docx文件的文件名称作为FLAG提交；（14分）', '015935f97dc60c9818cbda280e23e1a3b693d67d', 14, 1),
(28, 1, '4.5 Windows操作系统渗透测试（100分）', '任务环境说明：\n服务器场景：BJST\n服务器场景操作系统：BJST\n\n5.通过本地PC中渗透测试平台Kali对服务器场景BJST进行渗透测试，将该场景桌面上111文件夹中唯一一个后缀为.docx文件的文档内容作为FLAG提交；（16分）', '52d7b44f256e6431e9b9248884294d13c6c38c12', 16, 1),
(29, 1, '4.6 Windows操作系统渗透测试（100分）', '任务环境说明：\n服务器场景：BJST\n服务器场景操作系统：BJST\n\n6.通过本地PC中渗透测试平台Kali对服务器场景BJST进行渗透测试，将该场景桌面上222文件夹中唯一一个图片中的英文单词作为FLAG提交；（15分）', 'Security Life', 15, 1),
(30, 1, '4.7 Windows操作系统渗透测试（100分）', '任务环境说明：\n服务器场景：BJST\n服务器场景操作系统：BJST\n\n7.通过本地PC中渗透测试平台Kali对服务器场景BJST进行渗透测试，将该场景中的当前最高账户管理员的密码作为FLAG提交；（10分）', 'toor123', 10, 1),
(31, 1, '4.8 Windows操作系统渗透测试（100分）', '任务环境说明：\n服务器场景：BJST\n服务器场景操作系统：BJST\n\n8.通过本地PC中渗透测试平台Kali对服务器场景BJST进行渗透测试，将该场景中回收站内文件的文档内容作为FLAG提交。（20分）', '089f4e36079ef2742d5efc7def5a5bf5768f6c6e', 20, 1),
(32, 1, '5.1 Linux操作系统渗透测试（100分）', '<font color="#FF0000">这题可能有点问题 如果3306端口版本扫描为空的话并且 mysql -h * -u root -p 连接不到数据库的情况下 需要对mysql配置进行更改.。。。</font>\n<font color="#FF0000">再修复过程中需要用到ssh连接 我再下面给出ssh密码，然后呢 请按照规则来 不要走歪路~~</font>\n<pre style="height:60px;">\n编辑 /etc/my.cnf文件 在[mysqld]配置部分 添加以下内容\nskip-name-resolve\n</pre>\n任务环境说明：\n服务器场景：CentOS5.5\n服务器场景操作系统：CentOS5.5\n\n1.通过本地PC中渗透测试平台Kali对服务器场景CentOS 5.5进行操作系统扫描渗透测试，并将该操作显示结果“OS Details：”之后的字符串作为FLAG提交；（6分）\n\n\n\n\n\n\n\n\n\n<font color="#FF0000">password：toor123</font>', 'Linux 2.6.9 - 2.6.30', 6, 1),
(33, 1, '5.2 Linux操作系统渗透测试（100分）', '任务环境说明：\n服务器场景：CentOS5.5\n服务器场景操作系统：CentOS5.5\n\n2.通过本地PC中渗透测试平台Kali对服务器场景CentOS 5.5进行系统服务及版本扫描渗透测试，并将该操作显示结果中MySQL数据库对应的服务版本信息字符串作为FLAG提交；（6分）', 'MySQL 5.0.77', 6, 1),
(34, 1, '5.3 Linux操作系统渗透测试（100分）', '任务环境说明：\n服务器场景：CentOS5.5\n服务器场景操作系统：CentOS5.5\n\n3.通过本地PC中渗透测试平台Kali对服务器场景CentOS 5.5进行渗透测试，将该场景/var/www/html目录中唯一一个后缀为.html文件的文件名称作为FLAG提交；（12分）', 'ab1835e40992858e', 12, 1),
(35, 1, '5.4 Linux操作系统渗透测试（100分）', '任务环境说明：\n服务器场景：CentOS5.5\n服务器场景操作系统：CentOS5.5\n\n4.通过本地PC中渗透测试平台Kali对服务器场景CentOS 5.5进行渗透测试，将该场景/var/www/html目录中唯一一个后缀为.html文件的文件内容作为FLAG提交；（16分）', '921501aaab1835e40992858ed90e54f5', 16, 1),
(36, 1, '5.5 Linux操作系统渗透测试（100分）', '任务环境说明：\n服务器场景：CentOS5.5\n服务器场景操作系统：CentOS5.5\n\n5.通过本地PC中渗透测试平台Kali对服务器场景CentOS 5.5进行渗透测试，将该场景/var/www/html目录中唯一一个后缀为.bmp文件的文件名称作为FLAG提交；（27分）', '015935f97dc60c9818cbda280e23e1a3b693d67d', 27, 1),
(37, 1, '5.6 Linux操作系统渗透测试（100分）', '任务环境说明：\n服务器场景：CentOS5.5\n服务器场景操作系统：CentOS5.5\n\n6.通过本地PC中渗透测试平台Kali对服务器场景CentOS 5.5进行渗透测试，将该场景/var/www/html目录中唯一一个后缀为.bmp文件的文件大小作为FLAG提交。（33分）', '123', 33, 1),
(38, 1, '6.1 程序安全渗透测试（100分）', '任务环境说明：\n服务器场景：CentOS5.5\n服务器场景操作系统：CentOS5.5\n\n1.从靶机服务器场景FTP服务器中下载文件ScanHostPort.py，编辑该程序文件，使该程序实现应有的功能，填写该文件当中空缺的FLAG1字符串，将该字符串作为Flag值提交；（20分）\n\nScanHostPort.py\n<pre>\nimport FLAG1\n\ndef FLAG2():  \n    for port in range(80, 81):\n        conn = FLAG3(2, 1)\n        try:\n            conn.connect((FLAG4, port))\n            print(''Port %d Is Open'' % port)\n            FLAG5.close()\n        except:\n            pass\nscanhostport()\n</pre>', 'socket', 20, 1),
(39, 1, '6.2 程序安全渗透测试（100分）', '任务环境说明：\n服务器场景：CentOS5.5\n服务器场景操作系统：CentOS5.5\n\n2.继续编辑该ScanHostPort.py程序文件，填写该文件当中空缺的FLAG2字符串，将该字符串作为Flag值提交；（20分）\n\nScanHostPort.py\n<pre>\nimport FLAG1\n\ndef FLAG2():  \n    for port in range(80, 81):\n        conn = FLAG3(2, 1)\n        try:\n            conn.connect((FLAG4, port))\n            print(''Port %d Is Open'' % port)\n            FLAG5.close()\n        except:\n            pass\nscanhostport()\n</pre>', 'scanhostport', 20, 1),
(40, 1, '6.3 程序安全渗透测试（100分）', '任务环境说明：\n服务器场景：CentOS5.5\n服务器场景操作系统：CentOS5.5\n\n3.继续编辑该ScanHostPort.py程序文件，填写该文件当中空缺的FLAG3字符串，将该字符串作为Flag值提交；（20分）\n\nScanHostPort.py\n<pre>\nimport FLAG1\n\ndef FLAG2():  \n    for port in range(80, 81):\n        conn = FLAG3(2, 1)\n        try:\n            conn.connect((FLAG4, port))\n            print(''Port %d Is Open'' % port)\n            FLAG5.close()\n        except:\n            pass\nscanhostport()\n</pre>', 'socket.socket', 20, 1),
(41, 1, '6.4 程序安全渗透测试（100分）', '任务环境说明：\n服务器场景：CentOS5.5\n服务器场景操作系统：CentOS5.5\n\n4.继续编辑该ScanHostPort.py程序文件，假设靶机IP为172.16.104.246，填写该文件当中空缺的FLAG4字符串，将该字符串作为Flag值提交；（10分）\n\nScanHostPort.py\n<pre>\nimport FLAG1\n\ndef FLAG2():  \n    for port in range(80, 81):\n        conn = FLAG3(2, 1)\n        try:\n            conn.connect((FLAG4, port))\n            print(''Port %d Is Open'' % port)\n            FLAG5.close()\n        except:\n            pass\nscanhostport()\n</pre>', '"172.16.104.246"', 10, 1),
(42, 1, '6.5 程序安全渗透测试（100分）', '任务环境说明：\n服务器场景：CentOS5.5\n服务器场景操作系统：CentOS5.5\n\n5.继续编辑该ScanHostPort.py程序文件，填写该文件当中空缺的FLAG5字符串，将该字符串作为Flag值提交。（20分）\n\nScanHostPort.py\n<pre>\nimport FLAG1\n\ndef FLAG2():  \n    for port in range(80, 81):\n        conn = FLAG3(2, 1)\n        try:\n            conn.connect((FLAG4, port))\n            print(''Port %d Is Open'' % port)\n            FLAG5.close()\n        except:\n            pass\nscanhostport()\n</pre>', 'conn', 20, 1),
(43, 1, '6.6 程序安全渗透测试（100分）', '任务环境说明：\n服务器场景：CentOS5.5\n服务器场景操作系统：CentOS5.5\n\n6.将该程序正确设置靶机IP并拿到攻击机Kali上运行，扫描靶机开放端口，将程序回显的字符串作为Flag值提交。（10分）\n\nScanHostPort.py\n<pre>\nimport FLAG1\n\ndef FLAG2():  \n    for port in range(80, 81):\n        conn = FLAG3(2, 1)\n        try:\n            conn.connect((FLAG4, port))\n            print(''Port %d Is Open'' % port)\n            FLAG5.close()\n        except:\n            pass\nscanhostport()\n</pre>', 'Port 80 Is Open', 10, 1),
(44, 1, '7.1 Web应用安全（100分）', '任务环境说明：\n服务器场景：CentOS5.5\n服务器场景操作系统：CentOS5.5\n\n1. 在攻击机通过浏览器访问主页http://靶机IP地址，通过Web应用程序渗透测试方法登录该产品网站，成功登陆后，点击超链接进入产品信息页面，通过Web应用程序渗透测试方法获得靶机/flaginfo.txt文件中的字符串，并利用Kali的sha256sum工具将该字符串通过SHA256运算后返回哈希值的十六进制结果的字符串作为Flag值提交；（14分）', '62a0851351db00616c2b1bdc378dac0c948d4f54e5642e348e32855ca63aa2f6', 14, 1),
(45, 1, '7.2 Web应用安全（100分）', '任务环境说明：\n服务器场景：CentOS5.5\n服务器场景操作系统：CentOS5.5\n\n2.从靶机服务器场景SMB服务器中下载文件loadimg1.php，编辑该PHP程序文件，使该程序实现能够对本任务第1题中的Web应用程序渗透测试过程进行安全防护，填写该文件当中空缺的FLAG1字符串，将该字符串作为Flag值提交；（14分）', 'file', 14, 1),
(46, 1, '7.3 Web应用安全（100分）', '任务环境说明：\n服务器场景：CentOS5.5\n服务器场景操作系统：CentOS5.5\n\n3.继续编辑本任务第2题中的PHP程序文件，使该程序实现能够对本任务第1题中的Web应用程序渗透测试过程进行安全防护，填写该文件当中空缺的FLAG2字符串，将该字符串作为Flag值提交；（14分）', 'array', 14, 1),
(47, 1, '7.4 Web应用安全（100分）', '任务环境说明：\n服务器场景：CentOS5.5\n服务器场景操作系统：CentOS5.5\n\n4.继续编辑本任务第2题中的PHP程序文件，使该程序实现能够对本任务第1题中的Web应用程序渗透测试过程进行安全防护，填写该文件当中空缺的FLAG3字符串，将该字符串作为Flag值提交；（14分）', 'foreach', 14, 1),
(48, 1, '7.5 Web应用安全（100分）', '任务环境说明：\n服务器场景：CentOS5.5\n服务器场景操作系统：CentOS5.5\n\n5.继续编辑本任务第2题中的PHP程序文件，使该程序实现能够对本任务第1题中的Web应用程序渗透测试过程进行安全防护，填写该文件当中空缺的FLAG4字符串，将该字符串作为Flag值提交；（14分）', 'empty', 14, 1),
(49, 1, '7.6 Web应用安全（100分）', '任务环境说明：\n服务器场景：CentOS5.5\n服务器场景操作系统：CentOS5.5\n\n6.继续编辑本任务第2题中的PHP程序文件，使该程序实现能够对本任务第1题中的Web应用程序渗透测试过程进行安全防护，填写该文件当中空缺的FLAG5字符串，将该字符串作为Flag值提交；（14分）', 'safe', 14, 1),
(50, 1, '7.7 Web应用安全（100分）', '任务环境说明：\n服务器场景：CentOS5.5\n服务器场景操作系统：CentOS5.5\n\n7.将编辑好后的loadimg1.php程序重命名为loadimg.php再上传至靶机SMB服务，并在攻击机通过本任务第1题中使用的Web应用程序渗透测试方法获得靶机/flaginfo.txt文件中的字符串，将此时Web页面弹出的字符串通过SHA256运算后返回的哈希值的十六进制结果的字符串作为Flag值提交。 （16分）', 'e7dd05a356481a01ffed230e605db2a338d8c74180ae92065116b8d629914f5e', 16, 1);

-- --------------------------------------------------------

--
-- 表的结构 `ld_answer_cls`
--

CREATE TABLE IF NOT EXISTS `ld_answer_cls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `ld_answer_cls`
--

INSERT INTO `ld_answer_cls` (`id`, `name`) VALUES
(1, '网络空间安全”模拟赛题');

-- --------------------------------------------------------

--
-- 表的结构 `ld_config`
--

CREATE TABLE IF NOT EXISTS `ld_config` (
  `keys` varchar(255) NOT NULL COMMENT '设置名',
  `value` text NOT NULL COMMENT '设置值',
  `ms` varchar(255) NOT NULL,
  PRIMARY KEY (`keys`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ld_config`
--

INSERT INTO `ld_config` (`keys`, `value`, `ms`) VALUES
('announcement', '欢迎来到网络安全竞赛答题平台！\r\n请遵守相关规定,请勿对本平台进行恶意攻击!\r\n1.请勿对题目进行破坏。\r\n2.请勿对本平台展开攻击,如果你发现漏洞请联系管理员修复。\r\n本赛场计时器与实际时间有1-3秒的误差,请选手抓紧时间做题。', '比赛的公告'),
('title', '网络安全竞赛答题平台', '平台的标题'),
('start_time', '0', '开始的时间戳'),
('stop_time', '0', '结束的时间戳'),
('open_time', '0', '开启或关闭比赛,如果为1 则开启比赛计时'),
('tips', '', '登录和注册页面的右侧代码'),
('timu', '1', '输入cls表中题目的ID调出题目,如果为空则默认显示公告'),
('reg_switch', '1', '开放注册'),
('display_ranking', '0', '是否允许普通用户访问排行榜页面');

-- --------------------------------------------------------

--
-- 表的结构 `ld_log`
--

CREATE TABLE IF NOT EXISTS `ld_log` (
  `id` int(8) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uid` int(8) NOT NULL COMMENT '选手id',
  `aid` int(8) NOT NULL COMMENT '题目id',
  `cid` int(11) NOT NULL,
  `answer` text NOT NULL COMMENT '答案',
  `an_time` time NOT NULL COMMENT '答题时间',
  `yn` int(1) NOT NULL DEFAULT '0' COMMENT '是否正确:1得0没',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ld_score`
--

CREATE TABLE IF NOT EXISTS `ld_score` (
  `id` int(8) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uid` int(8) NOT NULL COMMENT '选手ID',
  `aid` int(8) NOT NULL COMMENT '得分题目id',
  `cid` int(11) NOT NULL,
  `an_time` time NOT NULL COMMENT '答题时间',
  `score` int(7) NOT NULL COMMENT '分值',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ld_user`
--

CREATE TABLE IF NOT EXISTS `ld_user` (
  `id` int(8) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `user` varchar(16) NOT NULL COMMENT '用户名',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `login_ip` varchar(15) NOT NULL DEFAULT '0.0.0.0' COMMENT '最后登录IP',
  `login_time` varchar(11) NOT NULL COMMENT '最后登录时间',
  `isadmin` int(1) NOT NULL DEFAULT '0',
  `info` text,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `user` (`user`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
