USE [master]
GO
/****** Object:  Database [ple_vers10]    Script Date: 04/15/2014 14:15:39 ******/
CREATE DATABASE [ple_vers10] ON  PRIMARY 
( NAME = N'ple_vers10', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL10_50.MSSQLSERVER\MSSQL\DATA\ple_vers10.mdf' , SIZE = 3072KB , MAXSIZE = UNLIMITED, FILEGROWTH = 1024KB )
 LOG ON 
( NAME = N'ple_vers10_log', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL10_50.MSSQLSERVER\MSSQL\DATA\ple_vers10_log.ldf' , SIZE = 1024KB , MAXSIZE = 2048GB , FILEGROWTH = 10%)
GO
ALTER DATABASE [ple_vers10] SET COMPATIBILITY_LEVEL = 100
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [ple_vers10].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [ple_vers10] SET ANSI_NULL_DEFAULT OFF
GO
ALTER DATABASE [ple_vers10] SET ANSI_NULLS OFF
GO
ALTER DATABASE [ple_vers10] SET ANSI_PADDING OFF
GO
ALTER DATABASE [ple_vers10] SET ANSI_WARNINGS OFF
GO
ALTER DATABASE [ple_vers10] SET ARITHABORT OFF
GO
ALTER DATABASE [ple_vers10] SET AUTO_CLOSE OFF
GO
ALTER DATABASE [ple_vers10] SET AUTO_CREATE_STATISTICS ON
GO
ALTER DATABASE [ple_vers10] SET AUTO_SHRINK OFF
GO
ALTER DATABASE [ple_vers10] SET AUTO_UPDATE_STATISTICS ON
GO
ALTER DATABASE [ple_vers10] SET CURSOR_CLOSE_ON_COMMIT OFF
GO
ALTER DATABASE [ple_vers10] SET CURSOR_DEFAULT  GLOBAL
GO
ALTER DATABASE [ple_vers10] SET CONCAT_NULL_YIELDS_NULL OFF
GO
ALTER DATABASE [ple_vers10] SET NUMERIC_ROUNDABORT OFF
GO
ALTER DATABASE [ple_vers10] SET QUOTED_IDENTIFIER OFF
GO
ALTER DATABASE [ple_vers10] SET RECURSIVE_TRIGGERS OFF
GO
ALTER DATABASE [ple_vers10] SET  DISABLE_BROKER
GO
ALTER DATABASE [ple_vers10] SET AUTO_UPDATE_STATISTICS_ASYNC OFF
GO
ALTER DATABASE [ple_vers10] SET DATE_CORRELATION_OPTIMIZATION OFF
GO
ALTER DATABASE [ple_vers10] SET TRUSTWORTHY OFF
GO
ALTER DATABASE [ple_vers10] SET ALLOW_SNAPSHOT_ISOLATION OFF
GO
ALTER DATABASE [ple_vers10] SET PARAMETERIZATION SIMPLE
GO
ALTER DATABASE [ple_vers10] SET READ_COMMITTED_SNAPSHOT OFF
GO
ALTER DATABASE [ple_vers10] SET HONOR_BROKER_PRIORITY OFF
GO
ALTER DATABASE [ple_vers10] SET  READ_WRITE
GO
ALTER DATABASE [ple_vers10] SET RECOVERY SIMPLE
GO
ALTER DATABASE [ple_vers10] SET  MULTI_USER
GO
ALTER DATABASE [ple_vers10] SET PAGE_VERIFY CHECKSUM
GO
ALTER DATABASE [ple_vers10] SET DB_CHAINING OFF
GO
USE [ple_vers10]
GO
/****** Object:  Table [dbo].[users]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[users](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[userName] [varchar](255) NOT NULL,
	[midasId] [varchar](255) NOT NULL,
	[course] [varchar](255) NOT NULL,
	[section] [varchar](255) NOT NULL,
 CONSTRAINT [PK_users] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[users] ON
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (271, N'bob', N'bob', N'2014_test', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (273, N'charls', N'charls', N'2014_test', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (277, N'sandy', N'sandy', N'2014_test', N'section2')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (279, N'yogi', N'yogi', N'2014_test', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (285, N'dan', N'dan', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (287, N'awxmb8jeit', N'awxmb8jeit', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (293, N'c7bc3nerwx', N'c7bc3nerwx', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (295, N'zdjongtrnf', N'zdjongtrnf', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (296, N'nq8m4mvuga', N'nq8m4mvuga', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (300, N'q9y3whnmc3', N'q9y3whnmc3', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (304, N'y8agbzayxg', N'y8agbzayxg', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (305, N'vgglne2dsg', N'vgglne2dsg', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (308, N'ovrzt7ush0', N'ovrzt7ush0', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (313, N'i7ruer3hcn', N'i7ruer3hcn', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (314, N'uo8ybu6hfe', N'uo8ybu6hfe', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (315, N'hxgxf3ld9p', N'hxgxf3ld9p', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (317, N'rg7hejsba3', N'rg7hejsba3', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (324, N'np17qifhgp', N'np17qifhgp', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (327, N'macuser1', N'macuser1', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (328, N'ztdsnl6vgl', N'ztdsnl6vgl', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (330, N'xi9spmowa0', N'xi9spmowa0', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (334, N'ebjv70iwln', N'ebjv70iwln', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (335, N'loky31fzw3', N'loky31fzw3', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (336, N'muadhsl8j9', N'muadhsl8j9', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (344, N'ub9diu7cbe', N'ub9diu7cbe', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (345, N'oz6xswkuui', N'oz6xswkuui', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (350, N'a4htdsz3k0', N'a4htdsz3k0', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (351, N'wpkbwvaduh', N'wpkbwvaduh', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (352, N'swqqiej5dp', N'swqqiej5dp', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (356, N'drsczj3iz4', N'drsczj3iz4', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (357, N'gh2uosldxo', N'gh2uosldxo', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (358, N'pl5a7evtmw', N'pl5a7evtmw', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (362, N'dr4pqc0k3a', N'dr4pqc0k3a', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (363, N'64drrdo8mb', N'64drrdo8mb', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (364, N'kkozcmrscn', N'kkozcmrscn', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (368, N'skk1lw1kw1', N'skk1lw1kw1', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (369, N'3eg3pferwl', N'3eg3pferwl', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (370, N'jkkrudrlxx', N'jkkrudrlxx', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (375, N'lastpc', N'lastpc', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (376, N'ekbstj0yre', N'ekbstj0yre', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (377, N'fiynbwodea', N'fiynbwodea', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (378, N'jxkmexva7w', N'jxkmexva7w', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (392, N'dexter', N'dexter', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (395, N'johnv', N'johnv', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (397, N'morgan', N'morgan', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (399, N'ashley', N'ashley', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (400, N'asdfasdfa', N'asdfasdfa', N'plecourse', N'section2')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (401, N'c66gedfyux', N'c66gedfyux', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (409, N'anita', N'anita', N'plecourse', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (414, N'daniel', N'daniel', N'2014_test', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (466, N'ruby', N'ruby', N'2014_test1', N'section2')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (467, N'amrita', N'amrita', N'2014_test1', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (469, N'jenis', N'jenis', N'2014_test', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (471, N'abhi', N'abhi', N'2014_test', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (484, N'sanjay', N'sanjay', N'2014_test', N'section1')
INSERT [dbo].[users] ([id], [userName], [midasId], [course], [section]) VALUES (485, N'priya', N'priya', N'2014_test', N'section2')
SET IDENTITY_INSERT [dbo].[users] OFF
/****** Object:  Table [dbo].[student_assgnmt_reminder]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[student_assgnmt_reminder](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[aid] [varchar](225) NULL,
	[mid] [varchar](225) NULL,
	[midas_id] [varchar](225) NULL,
	[course] [varchar](225) NULL,
	[section] [varchar](225) NULL,
	[due_date] [varchar](225) NULL,
	[day_before] [varchar](225) NULL,
	[week_before] [varchar](225) NULL,
	[on_date] [varchar](225) NULL,
 CONSTRAINT [PK_student_assgnmt_reminder] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[student_assgnmt_reminder] ON
INSERT [dbo].[student_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date]) VALUES (25, N'1', N'mod1', N'marry', N'test', N'section1', N'1', N'1', N'1', N'1391106600')
INSERT [dbo].[student_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date]) VALUES (26, N'2', N'mod1', N'marry', N'test', N'section1', N'0', N'0', N'0', N'0')
INSERT [dbo].[student_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date]) VALUES (27, N'3', N'mod1', N'marry', N'test', N'section1', N'0', N'0', N'0', N'0')
INSERT [dbo].[student_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date]) VALUES (28, N'4', N'mod1', N'marry', N'test', N'section1', N'0', N'0', N'0', N'0')
INSERT [dbo].[student_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date]) VALUES (29, N'5', N'mod1', N'marry', N'test', N'section1', N'0', N'0', N'0', N'0')
INSERT [dbo].[student_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date]) VALUES (30, N'6', N'mod2', N'marry', N'test', N'section1', N'0', N'0', N'0', N'0')
INSERT [dbo].[student_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date]) VALUES (31, N'7', N'mod2', N'marry', N'test', N'section1', N'0', N'0', N'0', N'0')
INSERT [dbo].[student_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date]) VALUES (32, N'8', N'mod2', N'marry', N'test', N'section1', N'0', N'0', N'0', N'0')
INSERT [dbo].[student_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date]) VALUES (33, N'1', N'mod1', N'sanjay', N'test', N'section1', N'1', N'1', N'1', N'1393439400')
INSERT [dbo].[student_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date]) VALUES (34, N'2', N'mod1', N'sanjay', N'test', N'section1', N'0', N'0', N'0', N'0')
INSERT [dbo].[student_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date]) VALUES (35, N'3', N'mod1', N'sanjay', N'test', N'section1', N'1', N'0', N'1', N'1392748200')
INSERT [dbo].[student_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date]) VALUES (36, N'4', N'mod1', N'sanjay', N'test', N'section1', N'0', N'1', N'0', N'1392748200')
INSERT [dbo].[student_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date]) VALUES (37, N'5', N'mod1', N'sanjay', N'test', N'section1', N'0', N'0', N'0', N'0')
INSERT [dbo].[student_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date]) VALUES (38, N'6', N'mod2', N'sanjay', N'test', N'section1', N'0', N'1', N'1', N'1393439400')
INSERT [dbo].[student_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date]) VALUES (39, N'7', N'mod2', N'sanjay', N'test', N'section1', N'0', N'1', N'1', N'1393439400')
INSERT [dbo].[student_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date]) VALUES (40, N'8', N'mod2', N'sanjay', N'test', N'section1', N'0', N'0', N'0', N'0')
SET IDENTITY_INSERT [dbo].[student_assgnmt_reminder] OFF
/****** Object:  Table [dbo].[ple_user_reminder_setting]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_user_reminder_setting](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[user_name] [varchar](255) NULL,
	[user_type] [varchar](255) NULL,
	[content_page_id] [varchar](255) NULL,
	[section] [varchar](255) NULL,
	[course] [varchar](255) NULL,
	[is_email] [int] NOT NULL,
	[is_feed_reader] [int] NOT NULL,
	[is_text_msg] [int] NOT NULL,
	[is_facebook] [int] NOT NULL,
	[is_twitter] [int] NOT NULL,
 CONSTRAINT [PK_ple_user_reminder_setting] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[ple_user_reminder_setting] ON
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (13, N'sanjay', N'student', N'content1', N'section1', N'test', 1, 0, 0, 1, 1)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (14, N'tarun', N'instructor', N'content1', N'section1', N'test', 1, 0, 0, 1, 1)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (15, N'richa', N'student', N'content1', N'section2', N'test', 1, 0, 0, 1, 1)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (16, N'sanjay', N'student', N'content1', N'section2', N'test', 1, 0, 0, 1, 1)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (17, N'priya', N'student', N'content1', N'section2', N'test', 1, 0, 0, 1, 1)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (18, N'marry', N'student', N'content1', N'section1', N'plecourse', 0, 0, 0, 0, 0)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (19, N'tarun', N'instructor', N'content1', N'sewction1', N'test', 0, 0, 0, 0, 0)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (20, N'richa', N'student', N'content2', N'section2', N'test', 0, 0, 0, 0, 0)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (21, N'sanjay', N'student', N'content2', N'section1', N'test', 0, 0, 0, 0, 0)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (22, N'tarun', N'instructor', N'content2', N'section1', N'test', 0, 0, 0, 0, 0)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (23, N'tarun', N'instructor', N'content3', N'section1', N'test', 0, 0, 0, 0, 0)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (24, N'sanjay', N'student', N'content4', N'section1', N'test', 0, 0, 0, 0, 0)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (25, N'tarun', N'instructor', N'content4', N'section1', N'test', 0, 0, 0, 0, 0)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (26, N'john', N'student', N'content1', N'section1', N'plecourse', 0, 0, 0, 0, 0)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (27, N'john', N'student', N'content2', N'section1', N'plecourse', 0, 0, 0, 0, 0)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (28, N'daniel', N'student', N'content2', N'section2', N'plecourse', 0, 0, 0, 0, 0)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (29, N'daniel', N'student', N'content3', N'section2', N'plecourse', 0, 0, 0, 0, 0)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (30, N'daniel', N'student', N'content4', N'section2', N'plecourse', 0, 0, 0, 0, 0)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (31, N'tarun1', N'student', N'content1', N'section1', N'test', 0, 0, 0, 0, 0)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (32, N'priya', N'instructor', N'content1', N'section', N'2014_test', 0, 0, 0, 0, 0)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (33, N'priya', N'instructor', N'content1', N'section2', N'2014_test', 0, 0, 0, 0, 0)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (34, N'tarun', N'instructor', N'content1', N'section1', N'2014_test', 1, 0, 0, 1, 1)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (35, N'tarun', N'instructor', N'content2', N'section1', N'2014_test', 0, 0, 0, 0, 0)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (36, N'chris', N'student', N'content1', N'section2', N'2014_test', 0, 0, 0, 0, 0)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (37, N'sanjay', N'student', N'content1', N'section1', N'2014_test', 1, 0, 0, 1, 1)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (38, N'sanjay', N'student', N'content2', N'section1', N'2014_test', 0, 0, 0, 0, 0)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (39, N'richa', N'student', N'content1', N'section2', N'2014_test', 0, 0, 0, 0, 0)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (40, N'tarun', N'instructor', N'content3', N'section1', N'2014_test', 0, 0, 0, 0, 0)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (41, N'sanjay', N'student', N'content3', N'section1', N'2014_test', 0, 0, 0, 0, 0)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (42, N'priya', N'instructor', N'content3', N'section2', N' 2014_test', 0, 0, 0, 0, 0)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (43, N'richa', N'student', N'content3', N'section2', N'2014_test', 0, 0, 0, 0, 0)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (44, N'priya', N'instructor', N'content3', N'section2', N'2014_test', 1, 0, 0, 1, 1)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (45, N'ajax', N'student', N'content1', N'section1', N'2014_test', 0, 0, 0, 0, 0)
INSERT [dbo].[ple_user_reminder_setting] ([id], [user_name], [user_type], [content_page_id], [section], [course], [is_email], [is_feed_reader], [is_text_msg], [is_facebook], [is_twitter]) VALUES (46, N'daniel', N'student', N'content1', N'section1', N'2014_test', 1, 0, 0, 1, 1)
SET IDENTITY_INSERT [dbo].[ple_user_reminder_setting] OFF
/****** Object:  Table [dbo].[ple_user_map_twitter]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_user_map_twitter](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[midasId] [varchar](255) NULL,
	[twitterId] [varchar](255) NULL,
	[twitterScreenName] [varchar](255) NULL,
 CONSTRAINT [PK_ple_user_map_twitter] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[ple_user_map_twitter] ON
INSERT [dbo].[ple_user_map_twitter] ([id], [midasId], [twitterId], [twitterScreenName]) VALUES (2, N'sanjay', N'115992765', N'abhithinker')
INSERT [dbo].[ple_user_map_twitter] ([id], [midasId], [twitterId], [twitterScreenName]) VALUES (3, N'richa', N'1175048832', N'yogendra9891')
INSERT [dbo].[ple_user_map_twitter] ([id], [midasId], [twitterId], [twitterScreenName]) VALUES (5, N'priya', N'539826743', N'milan12122012')
INSERT [dbo].[ple_user_map_twitter] ([id], [midasId], [twitterId], [twitterScreenName]) VALUES (8, N'marry', N'0', N'')
INSERT [dbo].[ple_user_map_twitter] ([id], [midasId], [twitterId], [twitterScreenName]) VALUES (9, N'john', N'0', N'')
INSERT [dbo].[ple_user_map_twitter] ([id], [midasId], [twitterId], [twitterScreenName]) VALUES (10, N'daniel', N'1175048832', N'yogendra9891')
INSERT [dbo].[ple_user_map_twitter] ([id], [midasId], [twitterId], [twitterScreenName]) VALUES (11, N'tarun1', N'0', N'')
INSERT [dbo].[ple_user_map_twitter] ([id], [midasId], [twitterId], [twitterScreenName]) VALUES (12, N'tarun', N'1175048832', N'yogendra9891')
INSERT [dbo].[ple_user_map_twitter] ([id], [midasId], [twitterId], [twitterScreenName]) VALUES (13, N'chris', N'0', N'')
INSERT [dbo].[ple_user_map_twitter] ([id], [midasId], [twitterId], [twitterScreenName]) VALUES (14, N'ajax', N'0', N'')
SET IDENTITY_INSERT [dbo].[ple_user_map_twitter] OFF
/****** Object:  Table [dbo].[ple_user_map_facebook]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_user_map_facebook](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[midas_id] [varchar](255) NOT NULL,
	[facebook_id] [varchar](255) NOT NULL,
	[facebook_username] [varchar](255) NULL,
 CONSTRAINT [PK_ple_user_map_facebook] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[ple_user_map_facebook] ON
INSERT [dbo].[ple_user_map_facebook] ([id], [midas_id], [facebook_id], [facebook_username]) VALUES (5, N'richa', N'100007730580471', N'yogidaffodil')
INSERT [dbo].[ple_user_map_facebook] ([id], [midas_id], [facebook_id], [facebook_username]) VALUES (6, N'priya', N'100001399532401', N'munek.kumar')
INSERT [dbo].[ple_user_map_facebook] ([id], [midas_id], [facebook_id], [facebook_username]) VALUES (13, N'sanjay', N'100000762337754', N'abcode')
INSERT [dbo].[ple_user_map_facebook] ([id], [midas_id], [facebook_id], [facebook_username]) VALUES (14, N'tarun', N'100006366398421', N'prem.baboo.771')
INSERT [dbo].[ple_user_map_facebook] ([id], [midas_id], [facebook_id], [facebook_username]) VALUES (15, N'marry', N'0', N'')
INSERT [dbo].[ple_user_map_facebook] ([id], [midas_id], [facebook_id], [facebook_username]) VALUES (16, N'john', N'0', N'')
INSERT [dbo].[ple_user_map_facebook] ([id], [midas_id], [facebook_id], [facebook_username]) VALUES (17, N'prem', N'100006366398421', N'')
INSERT [dbo].[ple_user_map_facebook] ([id], [midas_id], [facebook_id], [facebook_username]) VALUES (18, N'abhi', N'100007730580471', N'')
INSERT [dbo].[ple_user_map_facebook] ([id], [midas_id], [facebook_id], [facebook_username]) VALUES (19, N'chris', N'0', N'')
INSERT [dbo].[ple_user_map_facebook] ([id], [midas_id], [facebook_id], [facebook_username]) VALUES (20, N'ajax', N'0', N'')
INSERT [dbo].[ple_user_map_facebook] ([id], [midas_id], [facebook_id], [facebook_username]) VALUES (21, N'daniel', N'100000762337754', N'abcode')
SET IDENTITY_INSERT [dbo].[ple_user_map_facebook] OFF
/****** Object:  Table [dbo].[ple_user_map_email]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_user_map_email](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[midas_id] [varchar](255) NULL,
	[email] [varchar](255) NULL,
	[section] [varchar](255) NULL,
	[course] [varchar](255) NULL,
 CONSTRAINT [PK_ple_user_map_email] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[ple_user_map_email] ON
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (19, N'tarun', N'yogendra.singh@daffodilsw.com', N'section1', N'2014_test')
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (20, N'sanjay', N'abhishek.gupta@daffodilsw.com', N'section1', N'2014_test')
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (21, N'priya', N'munek.kumar@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (22, N'chris', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (24, N'richa', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (25, N'ajax', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (26, N'abhi', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (27, N'anuj', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (28, N'asha', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (29, N'bob', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (30, N'charls', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (31, N'yogi', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (32, N'sandy', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (33, N'dexter', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (34, N'dan', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (35, N'awxmb8jeit', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (36, N'9ymtyjsptd', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (37, N'c7bc3nerwx', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (38, N'qjgbjiwyix', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (39, N'zdjongtrnf', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (40, N'nq8m4mvuga', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (41, N'q9y3whnmc3', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (42, N'y8agbzayxg', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (43, N'jompkgnhz5', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (44, N'hka2hpzcio', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (45, N'vgglne2dsg', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (46, N'ovrzt7ush0', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (47, N'i7ruer3hcn', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (48, N'hxgxf3ld9p', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (49, N'uo8ybu6hfe', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (50, N'c66gedfyux', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (51, N'rg7hejsba3', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (52, N'xi9spmowa0', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (53, N'2kk7ws9xfd', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (54, N'jxkmexva7w', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (55, N'np17qifhgp', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (56, N'macuser1', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (57, N'ztdsnl6vgl', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (58, N'muadhsl8j9', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (59, N'ebjv70iwln', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (60, N'loky31fzw3', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (61, N'j2gp6ej6d7', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (62, N'ub9diu7cbe', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (63, N'oz6xswkuui', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (64, N'a4htdsz3k0', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (65, N'swqqiej5dp', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (66, N'wpkbwvaduh', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (67, N'drsczj3iz4', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (68, N'gh2uosldxo', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (69, N'pl5a7evtmw', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (70, N'64drrdo8mb', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (71, N'kkozcmrscn', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (72, N'dr4pqc0k3a', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (73, N'jkkrudrlxx', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (74, N'skk1lw1kw1', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (75, N'3eg3pferwl', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (76, N'fiynbwodea', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (77, N'lastpc', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (78, N'ekbstj0yre', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (79, N'zgoop1os9e', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (80, N'johnv', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (81, N'asdfasdfa', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (82, N'morgan :)', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (83, N'ashley', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (84, N'morgan', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (85, N'anita', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (86, N'daniel', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (87, N'rinky', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (88, N'shalu', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (89, N'amrita', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (90, N'ruby', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
INSERT [dbo].[ple_user_map_email] ([id], [midas_id], [email], [section], [course]) VALUES (91, N'jenis', N'abhishek.gupta@daffodilsw.com', NULL, NULL)
SET IDENTITY_INSERT [dbo].[ple_user_map_email] OFF
/****** Object:  Table [dbo].[ple_settings]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_settings](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[course] [varchar](255) NOT NULL,
	[setting_type] [varchar](255) NOT NULL,
	[setting_value] [int] NOT NULL,
	[define_setting_value] [text] NOT NULL,
	[section] [nvarchar](max) NULL,
 CONSTRAINT [PK_ple_settings] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[ple_settings] ON
INSERT [dbo].[ple_settings] ([id], [course], [setting_type], [setting_value], [define_setting_value], [section]) VALUES (2, N'Nursing402', N'section', 2, N'test', N'section2')
INSERT [dbo].[ple_settings] ([id], [course], [setting_type], [setting_value], [define_setting_value], [section]) VALUES (5, N'plecourse', N'section', 2, N'test', N'section1')
INSERT [dbo].[ple_settings] ([id], [course], [setting_type], [setting_value], [define_setting_value], [section]) VALUES (7, N'test', N'section', 2, N'test', N'section1')
INSERT [dbo].[ple_settings] ([id], [course], [setting_type], [setting_value], [define_setting_value], [section]) VALUES (9, N'test', N'section', 2, N'test', N'section2')
INSERT [dbo].[ple_settings] ([id], [course], [setting_type], [setting_value], [define_setting_value], [section]) VALUES (10, N'Nursing402', N'section', 2, N'test', N'section1')
INSERT [dbo].[ple_settings] ([id], [course], [setting_type], [setting_value], [define_setting_value], [section]) VALUES (11, N'plecourse', N'section', 2, N'test', N'section2')
INSERT [dbo].[ple_settings] ([id], [course], [setting_type], [setting_value], [define_setting_value], [section]) VALUES (13, N'2014_test', N'section', 2, N'test', N'section2')
INSERT [dbo].[ple_settings] ([id], [course], [setting_type], [setting_value], [define_setting_value], [section]) VALUES (14, N'2014_test', N'section', 2, N'test', N'section1')
SET IDENTITY_INSERT [dbo].[ple_settings] OFF
/****** Object:  Table [dbo].[ple_reply_access]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_reply_access](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[user_id] [varchar](255) NOT NULL,
	[comment_id] [int] NOT NULL,
	[question_id] [int] NOT NULL,
	[course_name] [varchar](255) NOT NULL,
	[section_name] [varchar](255) NOT NULL,
	[is_read] [bit] NOT NULL,
 CONSTRAINT [PK_ple_relpy_access] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[ple_reply_access] ON
INSERT [dbo].[ple_reply_access] ([id], [user_id], [comment_id], [question_id], [course_name], [section_name], [is_read]) VALUES (310, N'richa', 24, 23, N'test', N'section2', 1)
INSERT [dbo].[ple_reply_access] ([id], [user_id], [comment_id], [question_id], [course_name], [section_name], [is_read]) VALUES (311, N'munek', 24, 23, N'test', N'section1', 1)
INSERT [dbo].[ple_reply_access] ([id], [user_id], [comment_id], [question_id], [course_name], [section_name], [is_read]) VALUES (312, N'munek', 25, 23, N'test', N'section1', 1)
SET IDENTITY_INSERT [dbo].[ple_reply_access] OFF
/****** Object:  Table [dbo].[ple_register_users]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_register_users](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[userName] [varchar](255) NOT NULL,
	[midasId] [varchar](255) NOT NULL,
	[user_type] [varchar](255) NULL,
	[name] [varchar](255) NULL,
	[email] [varchar](255) NULL,
	[course] [varchar](255) NULL,
	[section] [varchar](255) NULL,
	[profile_pic] [varchar](255) NULL,
 CONSTRAINT [PK_ple_register_users] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[ple_register_users] ON
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (74, N'tarun', N'tarun', N'instructor', N'tarun', N'abhishek.gupta@daffodilsw.com', N'2014_test', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (75, N'sanjay', N'sanjay', N'student', N'sanjay', N'abhishek.gupta@daffodilsw.com', N'2014_test', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (77, N'chris', N'chris', N'student', N'chris', N'abhishek.gupta@daffodilsw.com', N'2014_test', N'section2', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (81, N'priya', N'priya', N'instructor', N'priya', N'abhishek.gupta@daffodilsw.com', N'2014_test', N'section2', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (82, N'richa', N'richa', N'student', N'richa', N'abhishek.gupta@daffodilsw.com', N'2014_test', N'section2', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (85, N'ajax', N'ajax', N'student', N'ajax', N'abhishek.gupta@daffodilsw.com', N'2014_test', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (86, N'abhi', N'abhi', N'student', N'abhi', N'abhishek.gupta@daffodilsw.com', N'2014_test', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (87, N'anuj', N'anuj', N'student', N'anuj', N'abhishek.gupta@daffodilsw.com', N'2014_test', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (88, N'asha', N'asha', N'student', N'asha', N'abhishek.gupta@daffodilsw.com', N'2014_test', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (89, N'bob', N'bob', N'student', N'bob', N'abhishek.gupta@daffodilsw.com', N'2014_test', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (90, N'charls', N'charls', N'student', N'charls', N'abhishek.gupta@daffodilsw.com', N'2014_test', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (91, N'yogi', N'yogi', N'student', N'yogi', N'abhishek.gupta@daffodilsw.com', N'2014_test', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (92, N'sandy', N'sandy', N'student', N'sandy', N'abhishek.gupta@daffodilsw.com', N'2014_test', N'section2', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (93, N'dexter', N'dexter', N'student', N'dexter', N'abhishek.gupta@daffodilsw.com', N'2014_test1', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (95, N'dan', N'dan', N'student', N'dan', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (96, N'awxmb8jeit', N'awxmb8jeit', N'student', N'awxmb8jeit', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (97, N'9ymtyjsptd', N'9ymtyjsptd', N'student', N'9ymtyjsptd', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (98, N'c7bc3nerwx', N'c7bc3nerwx', N'student', N'c7bc3nerwx', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (99, N'qjgbjiwyix', N'qjgbjiwyix', N'student', N'qjgbjiwyix', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (100, N'zdjongtrnf', N'zdjongtrnf', N'student', N'zdjongtrnf', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (101, N'nq8m4mvuga', N'nq8m4mvuga', N'student', N'nq8m4mvuga', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (102, N'q9y3whnmc3', N'q9y3whnmc3', N'student', N'q9y3whnmc3', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (103, N'y8agbzayxg', N'y8agbzayxg', N'student', N'y8agbzayxg', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (104, N'jompkgnhz5', N'jompkgnhz5', N'student', N'jompkgnhz5', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (105, N'hka2hpzcio', N'hka2hpzcio', N'student', N'hka2hpzcio', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (106, N'vgglne2dsg', N'vgglne2dsg', N'student', N'vgglne2dsg', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (107, N'ovrzt7ush0', N'ovrzt7ush0', N'student', N'ovrzt7ush0', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (108, N'i7ruer3hcn', N'i7ruer3hcn', N'student', N'i7ruer3hcn', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (109, N'hxgxf3ld9p', N'hxgxf3ld9p', N'student', N'hxgxf3ld9p', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (110, N'uo8ybu6hfe', N'uo8ybu6hfe', N'student', N'uo8ybu6hfe', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (111, N'c66gedfyux', N'c66gedfyux', N'student', N'c66gedfyux', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (112, N'rg7hejsba3', N'rg7hejsba3', N'student', N'rg7hejsba3', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (113, N'xi9spmowa0', N'xi9spmowa0', N'student', N'xi9spmowa0', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (114, N'2kk7ws9xfd', N'2kk7ws9xfd', N'student', N'2kk7ws9xfd', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (115, N'jxkmexva7w', N'jxkmexva7w', N'student', N'jxkmexva7w', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (116, N'np17qifhgp', N'np17qifhgp', N'student', N'np17qifhgp', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (117, N'macuser1', N'macuser1', N'student', N'macuser1', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (118, N'ztdsnl6vgl', N'ztdsnl6vgl', N'student', N'ztdsnl6vgl', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (119, N'muadhsl8j9', N'muadhsl8j9', N'student', N'muadhsl8j9', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (120, N'ebjv70iwln', N'ebjv70iwln', N'student', N'ebjv70iwln', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (121, N'loky31fzw3', N'loky31fzw3', N'student', N'loky31fzw3', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (122, N'j2gp6ej6d7', N'j2gp6ej6d7', N'student', N'j2gp6ej6d7', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (123, N'ub9diu7cbe', N'ub9diu7cbe', N'student', N'ub9diu7cbe', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (124, N'oz6xswkuui', N'oz6xswkuui', N'student', N'oz6xswkuui', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (125, N'a4htdsz3k0', N'a4htdsz3k0', N'student', N'a4htdsz3k0', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (126, N'swqqiej5dp', N'swqqiej5dp', N'student', N'swqqiej5dp', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (127, N'wpkbwvaduh', N'wpkbwvaduh', N'student', N'wpkbwvaduh', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (128, N'drsczj3iz4', N'drsczj3iz4', N'student', N'drsczj3iz4', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (129, N'gh2uosldxo', N'gh2uosldxo', N'student', N'gh2uosldxo', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (130, N'pl5a7evtmw', N'pl5a7evtmw', N'student', N'pl5a7evtmw', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (131, N'64drrdo8mb', N'64drrdo8mb', N'student', N'64drrdo8mb', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (132, N'kkozcmrscn', N'kkozcmrscn', N'student', N'kkozcmrscn', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (133, N'dr4pqc0k3a', N'dr4pqc0k3a', N'student', N'dr4pqc0k3a', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (134, N'jkkrudrlxx', N'jkkrudrlxx', N'student', N'jkkrudrlxx', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (135, N'skk1lw1kw1', N'skk1lw1kw1', N'student', N'skk1lw1kw1', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (136, N'3eg3pferwl', N'3eg3pferwl', N'student', N'3eg3pferwl', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (137, N'fiynbwodea', N'fiynbwodea', N'student', N'fiynbwodea', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (138, N'lastpc', N'lastpc', N'student', N'lastpc', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (139, N'ekbstj0yre', N'ekbstj0yre', N'student', N'ekbstj0yre', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (140, N'zgoop1os9e', N'zgoop1os9e', N'student', N'zgoop1os9e', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (141, N'johnv', N'johnv', N'student', N'johnv', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (142, N'asdfasdfa', N'asdfasdfa', N'student', N'asdfasdfa', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section2', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (143, N'morgan :)', N'morgan :)', N'student', N'morgan :)', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (144, N'ashley', N'ashley', N'student', N'ashley', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (145, N'morgan', N'morgan', N'student', N'morgan', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (146, N'anita', N'anita', N'student', N'anita', N'abhishek.gupta@daffodilsw.com', N'plecourse', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (147, N'daniel', N'daniel', N'student', N'daniel', N'abhishek.gupta@daffodilsw.com', N'2014_test', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (148, N'rinky', N'rinky', N'student', N'rinky', N'abhishek.gupta@daffodilsw.com', N'2014_test1', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (149, N'shalu', N'shalu', N'student', N'shalu', N'abhishek.gupta@daffodilsw.com', N'2014_test1', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (150, N'amrita', N'amrita', N'student', N'amrita', N'abhishek.gupta@daffodilsw.com', N'2014_test1', N'section1', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (151, N'ruby', N'ruby', N'student', N'ruby', N'abhishek.gupta@daffodilsw.com', N'2014_test1', N'section2', NULL)
INSERT [dbo].[ple_register_users] ([id], [userName], [midasId], [user_type], [name], [email], [course], [section], [profile_pic]) VALUES (152, N'jenis', N'jenis', N'student', N'jenis', N'abhishek.gupta@daffodilsw.com', N'2014_test', N'section1', NULL)
SET IDENTITY_INSERT [dbo].[ple_register_users] OFF
/****** Object:  Table [dbo].[ple_recent_post_setting]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_recent_post_setting](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[user_name] [varchar](255) NULL,
	[contentpage_id] [varchar](255) NULL,
	[course_name] [varchar](255) NULL,
	[section_name] [varchar](255) NULL,
	[count] [int] NULL,
	[view_name] [varchar](255) NULL,
 CONSTRAINT [PK_ple_recent_post_setting] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[ple_recent_post_setting] ON
INSERT [dbo].[ple_recent_post_setting] ([id], [user_name], [contentpage_id], [course_name], [section_name], [count], [view_name]) VALUES (836, N'priya', N'content1', N'2014_test', N'section', 4, N'activeposts')
INSERT [dbo].[ple_recent_post_setting] ([id], [user_name], [contentpage_id], [course_name], [section_name], [count], [view_name]) VALUES (837, N'priya', N'content1', N'2014_test', N'section2', 4, N'activeposts')
INSERT [dbo].[ple_recent_post_setting] ([id], [user_name], [contentpage_id], [course_name], [section_name], [count], [view_name]) VALUES (838, N'tarun', N'content1', N'2014_test', N'section1', 5, N'activepagesforum')
INSERT [dbo].[ple_recent_post_setting] ([id], [user_name], [contentpage_id], [course_name], [section_name], [count], [view_name]) VALUES (839, N'tarun', N'content2', N'2014_test', N'section1', 4, N'activeposts')
INSERT [dbo].[ple_recent_post_setting] ([id], [user_name], [contentpage_id], [course_name], [section_name], [count], [view_name]) VALUES (840, N'chris', N'content1', N'2014_test', N'section2', 4, N'activepagesforum')
INSERT [dbo].[ple_recent_post_setting] ([id], [user_name], [contentpage_id], [course_name], [section_name], [count], [view_name]) VALUES (841, N'sanjay', N'content1', N'2014_test', N'section1', 5, N'activepagesforum')
INSERT [dbo].[ple_recent_post_setting] ([id], [user_name], [contentpage_id], [course_name], [section_name], [count], [view_name]) VALUES (842, N'sanjay', N'content2', N'2014_test', N'section1', 4, N'activepagesforum')
INSERT [dbo].[ple_recent_post_setting] ([id], [user_name], [contentpage_id], [course_name], [section_name], [count], [view_name]) VALUES (843, N'richa', N'content1', N'2014_test', N'section2', 4, N'activeposts')
INSERT [dbo].[ple_recent_post_setting] ([id], [user_name], [contentpage_id], [course_name], [section_name], [count], [view_name]) VALUES (844, N'tarun', N'content3', N'2014_test', N'section1', 4, N'activeposts')
INSERT [dbo].[ple_recent_post_setting] ([id], [user_name], [contentpage_id], [course_name], [section_name], [count], [view_name]) VALUES (845, N'sanjay', N'content3', N'2014_test', N'section1', 7, N'activeposts')
INSERT [dbo].[ple_recent_post_setting] ([id], [user_name], [contentpage_id], [course_name], [section_name], [count], [view_name]) VALUES (846, N'priya', N'content3', N' 2014_test', N'section2', 4, N'activeposts')
INSERT [dbo].[ple_recent_post_setting] ([id], [user_name], [contentpage_id], [course_name], [section_name], [count], [view_name]) VALUES (847, N'richa', N'content3', N'2014_test', N'section2', 4, N'activepagesforum')
INSERT [dbo].[ple_recent_post_setting] ([id], [user_name], [contentpage_id], [course_name], [section_name], [count], [view_name]) VALUES (848, N'priya', N'content3', N'2014_test', N'section2', 6, N'activeposts')
INSERT [dbo].[ple_recent_post_setting] ([id], [user_name], [contentpage_id], [course_name], [section_name], [count], [view_name]) VALUES (849, N'ajax', N'content1', N'2014_test', N'section1', 4, N'activeposts')
INSERT [dbo].[ple_recent_post_setting] ([id], [user_name], [contentpage_id], [course_name], [section_name], [count], [view_name]) VALUES (850, N'daniel', N'content1', N'2014_test', N'section1', 4, N'activeposts')
SET IDENTITY_INSERT [dbo].[ple_recent_post_setting] OFF
/****** Object:  Table [dbo].[ple_questions_thread]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_questions_thread](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[question_id] [int] NOT NULL,
	[parent_reply_id] [int] NOT NULL,
	[post_body] [text] NOT NULL,
	[post_date] [varchar](255) NOT NULL,
	[post_by] [varchar](255) NOT NULL,
	[user_coursename] [varchar](255) NOT NULL,
	[user_sectionname] [varchar](255) NOT NULL,
	[contentpage_id] [varchar](255) NOT NULL,
	[is_reply] [bit] NOT NULL,
	[is_draft] [bit] NOT NULL,
	[ancestor_id] [varchar](255) NOT NULL,
 CONSTRAINT [PK_ple_questions_thread] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[ple_questions_rating]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_questions_rating](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[question_id] [int] NOT NULL,
	[rate_by] [varchar](255) NOT NULL,
	[rate] [int] NOT NULL,
	[date] [varchar](255) NOT NULL,
	[course_name] [varchar](255) NOT NULL,
	[section_name] [varchar](255) NOT NULL,
	[content_page_id] [varchar](255) NOT NULL,
 CONSTRAINT [PK_ple_questions_rating] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[ple_questions_rating] ON
INSERT [dbo].[ple_questions_rating] ([id], [question_id], [rate_by], [rate], [date], [course_name], [section_name], [content_page_id]) VALUES (60, 1, N'tarun', 1, N'1395645965', N'2014_test', N'section1', N'content1')
INSERT [dbo].[ple_questions_rating] ([id], [question_id], [rate_by], [rate], [date], [course_name], [section_name], [content_page_id]) VALUES (61, 12, N'tarun', 4, N'1395819999', N'2014_test', N'section1', N'content3')
INSERT [dbo].[ple_questions_rating] ([id], [question_id], [rate_by], [rate], [date], [course_name], [section_name], [content_page_id]) VALUES (62, 12, N'sanjay', 5, N'1395820487', N'2014_test', N'section1', N'content3')
SET IDENTITY_INSERT [dbo].[ple_questions_rating] OFF
/****** Object:  Table [dbo].[ple_questions_access]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_questions_access](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[user_id] [varchar](255) NOT NULL,
	[question_id] [int] NOT NULL,
	[course_name] [varchar](255) NOT NULL,
	[section_name] [varchar](255) NOT NULL,
	[is_read] [bit] NOT NULL,
	[is_pin] [bit] NOT NULL,
	[is_flag] [bit] NOT NULL,
	[parent_id] [int] NOT NULL,
	[post_type] [varchar](255) NOT NULL,
 CONSTRAINT [PK_ple_questions_access] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[ple_questions_access] ON
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (830, N'tarun', 1, N'2014_test', N'section1', 1, 0, 0, 0, N'question')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (831, N'tarun', 2, N'2014_test', N'section1', 1, 0, 0, 1, N'comment')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (832, N'tarun', 3, N'2014_test', N'section1', 1, 0, 0, 1, N'comment')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (833, N'sanjay', 4, N'2014_test', N'section1', 1, 0, 0, 0, N'question')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (834, N'sanjay', 5, N'2014_test', N'section1', 1, 0, 0, 0, N'question')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (835, N'sanjay', 6, N'2014_test', N'section1', 1, 0, 0, 0, N'question')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (836, N'sanjay', 7, N'2014_test', N'section1', 1, 0, 0, 6, N'comment')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (837, N'sanjay', 1, N'2014_test', N'section1', 1, 0, 0, 0, N'question')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (838, N'sanjay', 3, N'2014_test', N'section1', 1, 0, 0, 1, N'comment')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (839, N'richa', 8, N'2014_test', N'section2', 1, 0, 0, 0, N'question')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (840, N'tarun', 9, N'2014_test', N'section1', 1, 0, 0, 0, N'question')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (841, N'tarun', 8, N'2014_test', N'section1', 1, 0, 0, 0, N'question')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (842, N'tarun', 6, N'2014_test', N'section1', 1, 0, 0, 0, N'question')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (843, N'tarun', 10, N'2014_test', N'section1', 1, 0, 0, 6, N'comment')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (844, N'sanjay', 11, N'2014_test', N'section1', 1, 0, 0, 0, N'question')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (845, N'tarun', 12, N'2014_test', N'section1', 1, 0, 0, 0, N'question')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (846, N'sanjay', 12, N'2014_test', N'section1', 1, 0, 0, 0, N'question')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (847, N'sanjay', 13, N'2014_test', N'section1', 1, 0, 0, 12, N'comment')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (848, N'sanjay', 14, N'2014_test', N'section1', 1, 0, 0, 12, N'comment')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (849, N'tarun', 11, N'2014_test', N'section1', 1, 0, 0, 0, N'question')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (850, N'richa', 15, N'2014_test', N'section2', 1, 0, 0, 0, N'question')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (851, N'richa', 16, N'2014_test', N'section2', 1, 0, 0, 0, N'question')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (852, N'priya', 11, N'2014_test', N'section2', 1, 0, 0, 0, N'question')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (853, N'priya', 17, N'2014_test', N'section2', 1, 0, 0, 0, N'question')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (854, N'sanjay', 9, N'2014_test', N'section1', 1, 0, 0, 0, N'question')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (855, N'sanjay', 18, N'2014_test', N'section1', 1, 0, 0, 9, N'comment')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (856, N'richa', 19, N'2014_test', N'section2', 1, 0, 0, 16, N'comment')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (857, N'richa', 20, N'2014_test', N'section2', 1, 0, 0, 15, N'comment')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (858, N'tarun', 21, N'2014_test', N'section1', 1, 0, 0, 0, N'question')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (859, N'tarun', 22, N'2014_test', N'section1', 1, 0, 0, 0, N'question')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (860, N'tarun', 23, N'2014_test', N'section1', 1, 0, 0, 0, N'question')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (861, N'tarun', 24, N'2014_test', N'section1', 1, 0, 0, 0, N'question')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (862, N'tarun', 25, N'2014_test', N'section1', 1, 0, 0, 0, N'question')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (863, N'tarun', 26, N'2014_test', N'section1', 1, 0, 0, 0, N'question')
INSERT [dbo].[ple_questions_access] ([id], [user_id], [question_id], [course_name], [section_name], [is_read], [is_pin], [is_flag], [parent_id], [post_type]) VALUES (864, N'tarun', 27, N'2014_test', N'section1', 1, 0, 0, 0, N'question')
SET IDENTITY_INSERT [dbo].[ple_questions_access] OFF
/****** Object:  Table [dbo].[ple_questions]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_questions](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[post_subject] [nvarchar](4000) NOT NULL,
	[post_body] [text] NOT NULL,
	[post_date] [varchar](255) NOT NULL,
	[user_type] [varchar](255) NOT NULL,
	[post_by] [varchar](255) NOT NULL,
	[is_reply] [bit] NOT NULL,
	[contentpage_id] [varchar](255) NOT NULL,
	[user_coursename] [varchar](255) NOT NULL,
	[user_sectionname] [varchar](255) NOT NULL,
	[is_draft] [bit] NOT NULL,
	[question_id] [int] NULL,
	[parent_reply_id] [int] NULL,
	[ancestor_id] [text] NULL,
	[post_type] [varchar](50) NULL,
 CONSTRAINT [PK_ple_questions] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[ple_questions] ON
INSERT [dbo].[ple_questions] ([id], [post_subject], [post_body], [post_date], [user_type], [post_by], [is_reply], [contentpage_id], [user_coursename], [user_sectionname], [is_draft], [question_id], [parent_reply_id], [ancestor_id], [post_type]) VALUES (1, N'Section 1.10.32 of "de Finibus Bonorum et Malorum", written by Cicero in 45 BC', N'<p>&quot;Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?&quot;</p>

<h3>1914 translation by H. Rackham</h3>

<p>&quot;But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?&quot;</p>

<h3>Section 1.10.33 of &quot;de Finibus Bonorum et Malorum&quot;, written by Cicero in 45 BC</h3>

<p>&quot;At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.&quot;</p>
', N'1395645651', N'instructor', N'tarun', 1, N'content1', N'2014_test', N'section1', 0, NULL, NULL, NULL, N'question')
INSERT [dbo].[ple_questions] ([id], [post_subject], [post_body], [post_date], [user_type], [post_by], [is_reply], [contentpage_id], [user_coursename], [user_sectionname], [is_draft], [question_id], [parent_reply_id], [ancestor_id], [post_type]) VALUES (2, N'Section 1.10.32 of "de Finibus Bonorum et Malorum", written by Cicero in 45 BC', N'<p>asdaesdwe</p>
', N'1395645728', N'instructor', N'tarun', 1, N'content1', N'2014_test', N'section1', 0, 1, 0, N'0', N'comment')
INSERT [dbo].[ple_questions] ([id], [post_subject], [post_body], [post_date], [user_type], [post_by], [is_reply], [contentpage_id], [user_coursename], [user_sectionname], [is_draft], [question_id], [parent_reply_id], [ancestor_id], [post_type]) VALUES (3, N'Section 1.10.32 of "de Finibus Bonorum et Malorum", written by Cicero in 45 BC', N'<p>sasdsddsds</p>
', N'1395645742', N'instructor', N'tarun', 1, N'content1', N'2014_test', N'section1', 0, 1, 0, N'0', N'comment')
INSERT [dbo].[ple_questions] ([id], [post_subject], [post_body], [post_date], [user_type], [post_by], [is_reply], [contentpage_id], [user_coursename], [user_sectionname], [is_draft], [question_id], [parent_reply_id], [ancestor_id], [post_type]) VALUES (4, N'dfsdf', N'<p>dfsdfs</p>
', N'1395740337', N'student', N'sanjay', 0, N'content1', N'2014_test', N'section1', 0, NULL, NULL, NULL, N'question')
INSERT [dbo].[ple_questions] ([id], [post_subject], [post_body], [post_date], [user_type], [post_by], [is_reply], [contentpage_id], [user_coursename], [user_sectionname], [is_draft], [question_id], [parent_reply_id], [ancestor_id], [post_type]) VALUES (5, N'tyhfh', N'<p>fghfghf</p>
', N'1395740875', N'student', N'sanjay', 0, N'content2', N'2014_test', N'section1', 0, NULL, NULL, NULL, N'question')
INSERT [dbo].[ple_questions] ([id], [post_subject], [post_body], [post_date], [user_type], [post_by], [is_reply], [contentpage_id], [user_coursename], [user_sectionname], [is_draft], [question_id], [parent_reply_id], [ancestor_id], [post_type]) VALUES (6, N'fghgfhf', N'<p>fghf</p>
', N'1395740878', N'student', N'sanjay', 1, N'content2', N'2014_test', N'section1', 0, NULL, NULL, NULL, N'question')
INSERT [dbo].[ple_questions] ([id], [post_subject], [post_body], [post_date], [user_type], [post_by], [is_reply], [contentpage_id], [user_coursename], [user_sectionname], [is_draft], [question_id], [parent_reply_id], [ancestor_id], [post_type]) VALUES (7, N'fghgfhf', N'<p>gfhjghjg</p>
', N'1395740882', N'student', N'sanjay', 1, N'content2', N'2014_test', N'section1', 0, 6, 0, N'0', N'comment')
INSERT [dbo].[ple_questions] ([id], [post_subject], [post_body], [post_date], [user_type], [post_by], [is_reply], [contentpage_id], [user_coursename], [user_sectionname], [is_draft], [question_id], [parent_reply_id], [ancestor_id], [post_type]) VALUES (8, N'priya section2 first question', N'<p>priya section2 first question</p>
', N'1395753063', N'student', N'richa', 0, N'content1', N'2014_test', N'section2', 0, NULL, NULL, NULL, N'question')
INSERT [dbo].[ple_questions] ([id], [post_subject], [post_body], [post_date], [user_type], [post_by], [is_reply], [contentpage_id], [user_coursename], [user_sectionname], [is_draft], [question_id], [parent_reply_id], [ancestor_id], [post_type]) VALUES (9, N'dfasd', N'<p>sdfs</p>
', N'1395811574', N'instructor', N'tarun', 1, N'content1', N'2014_test', N'section1', 0, NULL, NULL, NULL, N'question')
INSERT [dbo].[ple_questions] ([id], [post_subject], [post_body], [post_date], [user_type], [post_by], [is_reply], [contentpage_id], [user_coursename], [user_sectionname], [is_draft], [question_id], [parent_reply_id], [ancestor_id], [post_type]) VALUES (10, N'fghgfhf', N'<p>gfhf</p>
', N'1395815447', N'instructor', N'tarun', 1, N'content2', N'2014_test', N'section1', 0, 6, 7, N'0,7', N'comment')
INSERT [dbo].[ple_questions] ([id], [post_subject], [post_body], [post_date], [user_type], [post_by], [is_reply], [contentpage_id], [user_coursename], [user_sectionname], [is_draft], [question_id], [parent_reply_id], [ancestor_id], [post_type]) VALUES (11, N'"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium...', N'<p>&quot;Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium...&quot;Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium...&quot;Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium...&quot;Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium...&quot;Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium...</p>
', N'1395819725', N'student', N'sanjay', 0, N'content1', N'2014_test', N'section1', 0, NULL, NULL, NULL, N'question')
INSERT [dbo].[ple_questions] ([id], [post_subject], [post_body], [post_date], [user_type], [post_by], [is_reply], [contentpage_id], [user_coursename], [user_sectionname], [is_draft], [question_id], [parent_reply_id], [ancestor_id], [post_type]) VALUES (12, N'Test Question - Just 4 Testing', N'<p>Just 4 Testing.... Just 4 Testing.... Just 4 Testing.... Just 4 Testing.... Just 4 Testing.... Just 4 Testing.... Just 4 Testing.... Just 4 Testing.... Just 4 Testing.... Just 4 Testing.... Just 4 Testing.... Just 4 Testing.... Just 4 Testing.... Just 4 Testing.... Just 4 Testing.... Just 4 Testing.... Just 4 Testing.... Just 4 Testing.... Just 4 Testing.... Just 4 Testing....</p>
', N'1395819968', N'instructor', N'tarun', 1, N'content3', N'2014_test', N'section1', 0, NULL, NULL, NULL, N'question')
INSERT [dbo].[ple_questions] ([id], [post_subject], [post_body], [post_date], [user_type], [post_by], [is_reply], [contentpage_id], [user_coursename], [user_sectionname], [is_draft], [question_id], [parent_reply_id], [ancestor_id], [post_type]) VALUES (13, N'Test Question - Just 4 Testing', N'<p>Reply to Test Question</p>
', N'1395820513', N'student', N'sanjay', 1, N'content3', N'2014_test', N'section1', 0, 12, 0, N'0', N'comment')
INSERT [dbo].[ple_questions] ([id], [post_subject], [post_body], [post_date], [user_type], [post_by], [is_reply], [contentpage_id], [user_coursename], [user_sectionname], [is_draft], [question_id], [parent_reply_id], [ancestor_id], [post_type]) VALUES (14, N'Test Question - Just 4 Testing', N'<p>Reply to Reply</p>
', N'1395820579', N'student', N'sanjay', 1, N'content3', N'2014_test', N'section1', 0, 12, 0, N'0', N'comment')
INSERT [dbo].[ple_questions] ([id], [post_subject], [post_body], [post_date], [user_type], [post_by], [is_reply], [contentpage_id], [user_coursename], [user_sectionname], [is_draft], [question_id], [parent_reply_id], [ancestor_id], [post_type]) VALUES (15, N'Richa''s Question 1', N'<p><strong>Test Test Test Test&nbsp;Test Test Test Test&nbsp;Test Test Test Test&nbsp;Test Test Test Test&nbsp;Test Test Test Test&nbsp;Test Test Test Test&nbsp;Test Test</strong> <em>Test Test&nbsp;Test Test Test Test&nbsp;Test Test Test Test&nbsp;Test Test Test Test&nbsp;Test Test Test Test&nbsp;Test Test Test Test&nbsp;Test Test Test Test</em>&nbsp;<s>Test Test Test Test&nbsp;Test Test Test Test&nbsp;Test Test Test Test&nbsp;Test Test Test Test&nbsp;Test Test Test Test&nbsp;Test Test Test Test&nbsp;</s></p>
', N'1395821057', N'student', N'richa', 1, N'content3', N'2014_test', N'section2', 0, NULL, NULL, NULL, N'question')
INSERT [dbo].[ple_questions] ([id], [post_subject], [post_body], [post_date], [user_type], [post_by], [is_reply], [contentpage_id], [user_coursename], [user_sectionname], [is_draft], [question_id], [parent_reply_id], [ancestor_id], [post_type]) VALUES (16, N'Richa''s Question 2', N'<p><s>Test Test Test Test&nbsp;Test Test Test Test&nbsp;Test Test Test Test&nbsp;Test Test Test Test&nbsp;Test Test Test Test&nbsp;Test Test Test Test&nbsp;Test Test Test Test&nbsp;Test Test Test Test&nbsp;Test Test Test Test&nbsp;Test Test Test Test&nbsp;Test Test Test Test</s>&nbsp;<em><strong>Test Test Test Test&nbsp;Test Test Test Test&nbsp;Test Test Test Test&nbsp;Test Test Test Test&nbsp;Test Test Test Test&nbsp;Test Test Test Test&nbsp;Test Test Test Test&nbsp;Test Test Test Test&nbsp;Test Test Test Test&nbsp;</strong></em></p>
', N'1395821190', N'student', N'richa', 1, N'content3', N'2014_test', N'section2', 0, NULL, NULL, NULL, N'question')
INSERT [dbo].[ple_questions] ([id], [post_subject], [post_body], [post_date], [user_type], [post_by], [is_reply], [contentpage_id], [user_coursename], [user_sectionname], [is_draft], [question_id], [parent_reply_id], [ancestor_id], [post_type]) VALUES (17, N'Priya''s Question1', N'<p>Test TestTest Test Test Test TestTest TestTest Test Test Test TestTest TestTest Test Test Test TestTest TestTest Test Test Test TestTest TestTest Test Test Test TestTest TestTest Test Test Test TestTest TestTest Test Test Test TestTest TestTest Test Test Test TestTest TestTest Test Test Test TestTest TestTest Test Test Test TestTest TestTest Test Test Test TestTest TestTest Test Test Test Test</p>
', N'1395824293', N'instructor', N'priya', 0, N'content3', N'2014_test', N'section2', 0, NULL, NULL, NULL, N'question')
INSERT [dbo].[ple_questions] ([id], [post_subject], [post_body], [post_date], [user_type], [post_by], [is_reply], [contentpage_id], [user_coursename], [user_sectionname], [is_draft], [question_id], [parent_reply_id], [ancestor_id], [post_type]) VALUES (18, N'dfasd', N'<p>test</p>
', N'1395824517', N'student', N'sanjay', 1, N'content1', N'2014_test', N'section1', 1, 9, 0, N'0', N'comment')
INSERT [dbo].[ple_questions] ([id], [post_subject], [post_body], [post_date], [user_type], [post_by], [is_reply], [contentpage_id], [user_coursename], [user_sectionname], [is_draft], [question_id], [parent_reply_id], [ancestor_id], [post_type]) VALUES (19, N'Richa''s Question 2', N'<p>Re: RQ2</p>
', N'1395825427', N'student', N'richa', 1, N'content3', N'2014_test', N'section2', 0, 16, 0, N'0', N'comment')
INSERT [dbo].[ple_questions] ([id], [post_subject], [post_body], [post_date], [user_type], [post_by], [is_reply], [contentpage_id], [user_coursename], [user_sectionname], [is_draft], [question_id], [parent_reply_id], [ancestor_id], [post_type]) VALUES (20, N'Richa''s Question 1', N'<p>Re: RQ2</p>
', N'1395825679', N'student', N'richa', 1, N'content3', N'2014_test', N'section2', 0, 15, 0, N'0', N'comment')
INSERT [dbo].[ple_questions] ([id], [post_subject], [post_body], [post_date], [user_type], [post_by], [is_reply], [contentpage_id], [user_coursename], [user_sectionname], [is_draft], [question_id], [parent_reply_id], [ancestor_id], [post_type]) VALUES (21, N'efsdf', N'<p>sgfsf</p>
', N'1397021246', N'instructor', N'tarun', 0, N'content1', N'2014_test', N'section1', 0, NULL, NULL, NULL, N'question')
INSERT [dbo].[ple_questions] ([id], [post_subject], [post_body], [post_date], [user_type], [post_by], [is_reply], [contentpage_id], [user_coursename], [user_sectionname], [is_draft], [question_id], [parent_reply_id], [ancestor_id], [post_type]) VALUES (22, N'gsfgs', N'<p>sfgsf</p>
', N'1397021251', N'instructor', N'tarun', 0, N'content1', N'2014_test', N'section1', 0, NULL, NULL, NULL, N'question')
INSERT [dbo].[ple_questions] ([id], [post_subject], [post_body], [post_date], [user_type], [post_by], [is_reply], [contentpage_id], [user_coursename], [user_sectionname], [is_draft], [question_id], [parent_reply_id], [ancestor_id], [post_type]) VALUES (23, N'dfsdfgsd', N'<p>sfgsg</p>
', N'1397021254', N'instructor', N'tarun', 0, N'content1', N'2014_test', N'section1', 0, NULL, NULL, NULL, N'question')
INSERT [dbo].[ple_questions] ([id], [post_subject], [post_body], [post_date], [user_type], [post_by], [is_reply], [contentpage_id], [user_coursename], [user_sectionname], [is_draft], [question_id], [parent_reply_id], [ancestor_id], [post_type]) VALUES (24, N'dfgdg', N'<p>dfghgh</p>
', N'1397021258', N'instructor', N'tarun', 0, N'content1', N'2014_test', N'section1', 0, NULL, NULL, NULL, N'question')
INSERT [dbo].[ple_questions] ([id], [post_subject], [post_body], [post_date], [user_type], [post_by], [is_reply], [contentpage_id], [user_coursename], [user_sectionname], [is_draft], [question_id], [parent_reply_id], [ancestor_id], [post_type]) VALUES (25, N'ghfgh', N'<p>gd</p>
', N'1397021264', N'instructor', N'tarun', 0, N'content1', N'2014_test', N'section1', 0, NULL, NULL, NULL, N'question')
INSERT [dbo].[ple_questions] ([id], [post_subject], [post_body], [post_date], [user_type], [post_by], [is_reply], [contentpage_id], [user_coursename], [user_sectionname], [is_draft], [question_id], [parent_reply_id], [ancestor_id], [post_type]) VALUES (26, N'hjgujk', N'<p>gjkghukg</p>
', N'1397021267', N'instructor', N'tarun', 0, N'content1', N'2014_test', N'section1', 0, NULL, NULL, NULL, N'question')
INSERT [dbo].[ple_questions] ([id], [post_subject], [post_body], [post_date], [user_type], [post_by], [is_reply], [contentpage_id], [user_coursename], [user_sectionname], [is_draft], [question_id], [parent_reply_id], [ancestor_id], [post_type]) VALUES (27, N'asdasdra', N'<p>asda</p>
', N'1397021270', N'instructor', N'tarun', 0, N'content1', N'2014_test', N'section1', 0, NULL, NULL, NULL, N'question')
SET IDENTITY_INSERT [dbo].[ple_questions] OFF
/****** Object:  Table [dbo].[ple_post_twitter_queue]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_post_twitter_queue](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[twitter_id] [varchar](255) NULL,
	[mail_data] [text] NULL,
 CONSTRAINT [PK_twitter_mail_queue] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[ple_post_twitter_failure]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_post_twitter_failure](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[twitter_id] [varchar](255) NULL,
	[mail_data] [text] NULL,
 CONSTRAINT [PK_ple_twitter_mail_failure] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[ple_post_mail_queue]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_post_mail_queue](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[email] [varchar](255) NULL,
	[subject] [text] NULL,
	[mail_data] [text] NULL,
 CONSTRAINT [PK_ple_odu_mail_queue] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[ple_post_mail_failure]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_post_mail_failure](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[email] [varchar](255) NOT NULL,
	[subject] [varchar](255) NOT NULL,
	[mail_data] [text] NOT NULL,
 CONSTRAINT [PK_ple_odu_mail_failure] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[ple_post_facebook_queue]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_post_facebook_queue](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[facebook_id] [varchar](255) NULL,
	[mail_data] [text] NULL,
 CONSTRAINT [PK_ple_facebook_mail_queue] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[ple_post_facebook_failure]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_post_facebook_failure](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[facebook_id] [varchar](255) NOT NULL,
	[mail_data] [text] NOT NULL,
 CONSTRAINT [PK_ple_facebook_mail_failure] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[ple_page_forum_availability_new]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_page_forum_availability_new](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[course_id] [varchar](255) NOT NULL,
	[uuid] [varchar](255) NOT NULL,
	[user_id] [varchar](255) NOT NULL,
	[page_title] [varchar](255) NOT NULL,
	[post_begin_date] [datetime] NULL,
	[post_end_date] [datetime] NULL,
	[reply_begin_date] [datetime] NULL,
	[reply_end_date] [datetime] NULL,
	[read_only_begin_date] [datetime] NULL,
	[read_only_end_date] [datetime] NULL,
	[type] [varchar](255) NOT NULL,
 CONSTRAINT [PK_ple_page_forum_availability_new] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[ple_page_forum_availability_new] ON
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (1, N'2014_test-section1', N'module1', N'tarun', N'module_one', CAST(0x0000A2FB00000000 AS DateTime), CAST(0x0000A2FC00000000 AS DateTime), CAST(0x0000A2FA00000000 AS DateTime), CAST(0x0000A2FA00000000 AS DateTime), CAST(0x0000A2FC00000000 AS DateTime), CAST(0x0000BF7F00000000 AS DateTime), N'module')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (2, N'2014_test-section1', N'topic1', N'tarun', N'topic_one', CAST(0x0000A2FB00000000 AS DateTime), CAST(0x0000A2FC00000000 AS DateTime), CAST(0x0000A2FA00000000 AS DateTime), CAST(0x0000A2FA00000000 AS DateTime), CAST(0x0000A2FC00000000 AS DateTime), CAST(0x0000BF7F00000000 AS DateTime), N'topic')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (3, N'2014_test-section1', N'content1', N'tarun', N'contentpage_one', CAST(0x0000A2FB00000000 AS DateTime), CAST(0x0000A32B00000000 AS DateTime), CAST(0x0000A2FA00000000 AS DateTime), CAST(0x0000A2FA00000000 AS DateTime), CAST(0x0000A2FC00000000 AS DateTime), CAST(0x0000A2FD00000000 AS DateTime), N'contentpage')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (4, N'2014_test-section1', N'content2', N'tarun', N'contentpage_two', CAST(0x0000A2FB00000000 AS DateTime), CAST(0x0000A2FC00000000 AS DateTime), CAST(0x0000A2FA00000000 AS DateTime), CAST(0x0000A2FA00000000 AS DateTime), CAST(0x0000A2FC00000000 AS DateTime), CAST(0x0000BF7F00000000 AS DateTime), N'contentpage')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (5, N'2014_test-section1', N'topic2', N'tarun', N'topic_two', CAST(0x0000A2FB00000000 AS DateTime), CAST(0x0000A2FC00000000 AS DateTime), CAST(0x0000A2FA00000000 AS DateTime), CAST(0x0000A2FA00000000 AS DateTime), CAST(0x0000A2FC00000000 AS DateTime), CAST(0x0000BF7F00000000 AS DateTime), N'topic')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (6, N'2014_test-section1', N'content3', N'tarun', N'contentpage_three', CAST(0x0000A2FB00000000 AS DateTime), CAST(0x0000A2FC00000000 AS DateTime), CAST(0x0000A2FA00000000 AS DateTime), CAST(0x0000A2FA00000000 AS DateTime), CAST(0x0000A2FC00000000 AS DateTime), CAST(0x0000BF7F00000000 AS DateTime), N'contentpage')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (7, N'2014_test-section1', N'content10', N'tarun', N'contentpage_ten', NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), N'contentpage')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (8, N'2014_test-section1', N'content6', N'tarun', N'contentpage_six', NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), N'contentpage')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (9, N'2014_test-section1', N'content9', N'tarun', N'contentpage_nine', NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), N'contentpage')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (10, N'2014_test-section1', N'module3', N'tarun', N'module_three', NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), N'module')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (11, N'2014_test-section1', N'topic5', N'tarun', N'topic_five', NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), N'topic')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (12, N'2014_test-section1', N'content11', N'tarun', N'contentpage_eleven', NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), N'contentpage')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (13, N'2014_test-section1', N'module2', N'tarun', N'module_two', NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), N'module')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (14, N'2014_test-section1', N'topic4', N'tarun', N'topic_four', NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), N'topic')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (15, N'2014_test-section1', N'content4', N'tarun', N'contentpage_four', NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), N'contentpage')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (16, N'2014_test-section1', N'topic3', N'tarun', N'topic_three', NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), N'topic')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (17, N'2014_test-section1', N'content5', N'tarun', N'contentpage_five', NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), N'contentpage')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (18, N'2014_test-section1', N'content7', N'tarun', N'contentpage_seven', CAST(0x0000A2FB00000000 AS DateTime), CAST(0x0000A2FC00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), N'contentpage')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (19, N'2014_test-section1', N'content8', N'tarun', N'contentpage_eight', NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), N'contentpage')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (20, N'2014_test-section2', N'module1', N'priya', N'module_one', CAST(0x0000A2F900000000 AS DateTime), CAST(0x0000A2FF00000000 AS DateTime), CAST(0x0000A2F900000000 AS DateTime), CAST(0x0000A2FF00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), N'module')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (21, N'2014_test-section2', N'topic1', N'priya', N'topic_one', CAST(0x0000A2F900000000 AS DateTime), CAST(0x0000A2FF00000000 AS DateTime), CAST(0x0000A2F900000000 AS DateTime), CAST(0x0000A2FF00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), N'topic')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (22, N'2014_test-section2', N'content1', N'priya', N'contentpage_one', CAST(0x0000A2F900000000 AS DateTime), CAST(0x0000A2FF00000000 AS DateTime), CAST(0x0000A2F900000000 AS DateTime), CAST(0x0000A2FF00000000 AS DateTime), CAST(0x0000A2F900000000 AS DateTime), CAST(0x0000A2FB00000000 AS DateTime), N'contentpage')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (23, N'2014_test-section2', N'content2', N'priya', N'contentpage_two', CAST(0x0000A2F900000000 AS DateTime), CAST(0x0000A2FF00000000 AS DateTime), CAST(0x0000A2F900000000 AS DateTime), CAST(0x0000A2FF00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), N'contentpage')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (24, N'2014_test-section2', N'topic2', N'priya', N'topic_two', CAST(0x0000A2F900000000 AS DateTime), CAST(0x0000A2FF00000000 AS DateTime), CAST(0x0000A2F900000000 AS DateTime), CAST(0x0000A2FF00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), N'topic')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (25, N'2014_test-section2', N'content3', N'priya', N'contentpage_three', CAST(0x0000A2F900000000 AS DateTime), CAST(0x0000A36300000000 AS DateTime), CAST(0x0000A2F900000000 AS DateTime), CAST(0x0000A2FF00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), N'contentpage')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (26, N'2014_test-section2', N'content10', N'priya', N'contentpage_ten', NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), N'contentpage')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (27, N'2014_test-section2', N'content6', N'priya', N'contentpage_six', NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), N'contentpage')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (28, N'2014_test-section2', N'content9', N'priya', N'contentpage_nine', NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), N'contentpage')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (29, N'2014_test-section2', N'module3', N'priya', N'module_three', NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), N'module')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (30, N'2014_test-section2', N'topic5', N'priya', N'topic_five', NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), N'topic')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (31, N'2014_test-section2', N'content11', N'priya', N'contentpage_eleven', NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), N'contentpage')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (32, N'2014_test-section2', N'module2', N'priya', N'module_two', NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), N'module')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (33, N'2014_test-section2', N'topic4', N'priya', N'topic_four', NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), N'topic')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (34, N'2014_test-section2', N'content4', N'priya', N'contentpage_four', NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), N'contentpage')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (35, N'2014_test-section2', N'topic3', N'priya', N'topic_three', NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), N'topic')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (36, N'2014_test-section2', N'content5', N'priya', N'contentpage_five', NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), N'contentpage')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (37, N'2014_test-section2', N'content7', N'priya', N'contentpage_seven', NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), N'contentpage')
INSERT [dbo].[ple_page_forum_availability_new] ([id], [course_id], [uuid], [user_id], [page_title], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date], [type]) VALUES (38, N'2014_test-section2', N'content8', N'priya', N'contentpage_eight', NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), NULL, CAST(0x0000BF7F00000000 AS DateTime), N'contentpage')
SET IDENTITY_INSERT [dbo].[ple_page_forum_availability_new] OFF
/****** Object:  Table [dbo].[ple_page_forum_availability]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_page_forum_availability](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[course_id] [varchar](255) NOT NULL,
	[page_uuid] [varchar](255) NOT NULL,
	[user_id] [varchar](255) NOT NULL,
	[post_begin_date] [datetime] NULL,
	[post_end_date] [datetime] NULL,
	[reply_begin_date] [datetime] NULL,
	[reply_end_date] [datetime] NULL,
	[read_only_begin_date] [datetime] NULL,
	[read_only_end_date] [datetime] NULL,
 CONSTRAINT [PK_ple_page_forum_availability] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[ple_page_forum_availability] ON
INSERT [dbo].[ple_page_forum_availability] ([id], [course_id], [page_uuid], [user_id], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date]) VALUES (1, N'2014_test-section1', N'content1', N'tarun', CAST(0x0000A2B300C647C4 AS DateTime), CAST(0x0000A2FA0118AD84 AS DateTime), CAST(0x0000A2CE00C647C4 AS DateTime), CAST(0x0000A31700C647C4 AS DateTime), CAST(0x0000A2EE00C647C4 AS DateTime), CAST(0x0000A2F100C647C4 AS DateTime))
INSERT [dbo].[ple_page_forum_availability] ([id], [course_id], [page_uuid], [user_id], [post_begin_date], [post_end_date], [reply_begin_date], [reply_end_date], [read_only_begin_date], [read_only_end_date]) VALUES (2, N'2014_test-section1', N'content2', N'tarun', CAST(0x0000A2B300C647C4 AS DateTime), CAST(0x0000A2FA0118AD84 AS DateTime), CAST(0x0000A2CE00C647C4 AS DateTime), CAST(0x0000A2F800C647C4 AS DateTime), CAST(0x0000A2EE00C647C4 AS DateTime), CAST(0x0000A2F100C647C4 AS DateTime))
SET IDENTITY_INSERT [dbo].[ple_page_forum_availability] OFF
/****** Object:  Table [dbo].[ple_online_user_logs]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_online_user_logs](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[midas_id] [varchar](255) NOT NULL,
	[time] [varchar](255) NOT NULL,
	[course] [varchar](255) NOT NULL,
	[section] [varchar](255) NOT NULL,
	[session] [varchar](255) NOT NULL,
 CONSTRAINT [PK_ple_online_user_logs] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[ple_online_user_logs] ON
INSERT [dbo].[ple_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (1, N'tarun', N'1397286779', N'2014_test', N'section1', N'2014')
INSERT [dbo].[ple_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (2, N'sanjay', N'1397286889', N'2014_test', N'section1', N'2014')
INSERT [dbo].[ple_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (3, N'priya', N'1397286914', N'2014_test', N'section2', N'2014')
INSERT [dbo].[ple_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (4, N'richa', N'1397286924', N'2014_test', N'section2', N'2014')
INSERT [dbo].[ple_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (5, N'chris', N'1397286941', N'2014_test', N'section2', N'2014')
INSERT [dbo].[ple_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (6, N'rinky', N'1397286961', N'2014_test1', N'section1', N'2014')
INSERT [dbo].[ple_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (7, N'tarun', N'1397292123', N'2014_test', N'section1', N'2014')
INSERT [dbo].[ple_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (8, N'tarun', N'1397294479', N'2014_test', N'section1', N'2014')
INSERT [dbo].[ple_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (9, N'sanjay', N'1397294496', N'2014_test', N'section1', N'2014')
INSERT [dbo].[ple_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (10, N'shalu', N'1397296031', N'2014_test1', N'section1', N'2014')
INSERT [dbo].[ple_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (11, N'amrita', N'1397296048', N'2014_test1', N'section1', N'2014')
INSERT [dbo].[ple_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (12, N'ruby', N'1397296715', N'2014_test1', N'section2', N'2014')
INSERT [dbo].[ple_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (13, N'ruby', N'1397303205', N'2014_test1', N'section2', N'2014')
INSERT [dbo].[ple_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (14, N'amrita', N'1397303209', N'2014_test1', N'section1', N'2014')
INSERT [dbo].[ple_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (15, N'jenis', N'1397303223', N'2014_test', N'section1', N'2014')
INSERT [dbo].[ple_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (16, N'tarun', N'1397542889', N'2014_test', N'section1', N'2014')
INSERT [dbo].[ple_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (17, N'sanjay', N'1397542900', N'2014_test', N'section1', N'2014')
SET IDENTITY_INSERT [dbo].[ple_online_user_logs] OFF
/****** Object:  Table [dbo].[ple_online_setting_logs]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_online_setting_logs](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[midas_id] [varchar](225) NOT NULL,
	[time] [varchar](225) NOT NULL,
	[type] [int] NOT NULL,
	[section] [varchar](225) NOT NULL,
	[course] [varchar](225) NOT NULL,
	[session] [varchar](225) NOT NULL,
 CONSTRAINT [PK_ple_online_setting_logs] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[ple_online_setting_logs] ON
INSERT [dbo].[ple_online_setting_logs] ([id], [midas_id], [time], [type], [section], [course], [session]) VALUES (1, N'tarun', N'1397549157', 1, N'section1', N'2014_test', N'2014')
INSERT [dbo].[ple_online_setting_logs] ([id], [midas_id], [time], [type], [section], [course], [session]) VALUES (2, N'tarun', N'1397549158', 2, N'section1', N'2014_test', N'2014')
INSERT [dbo].[ple_online_setting_logs] ([id], [midas_id], [time], [type], [section], [course], [session]) VALUES (3, N'priya', N'1397549174', 1, N'section2', N'2014_test', N'2014')
SET IDENTITY_INSERT [dbo].[ple_online_setting_logs] OFF
/****** Object:  Table [dbo].[ple_meeting_invites_logs]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_meeting_invites_logs](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[meeting_id] [bigint] NOT NULL,
	[meeting_name] [varchar](225) NOT NULL,
	[midas_id] [varchar](225) NOT NULL,
	[user_type] [varchar](225) NOT NULL,
	[time] [varchar](225) NOT NULL,
	[section] [varchar](225) NOT NULL,
	[course] [varchar](225) NOT NULL,
	[session] [varchar](225) NOT NULL,
 CONSTRAINT [PK_ple_meeting_invites_logs] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[ple_meeting_invites_logs] ON
INSERT [dbo].[ple_meeting_invites_logs] ([id], [meeting_id], [meeting_name], [midas_id], [user_type], [time], [section], [course], [session]) VALUES (1, 167, N'rfrtft', N'abhi', N'receiver', N'1397303428', N'section1', N'2014_test', N'2014')
INSERT [dbo].[ple_meeting_invites_logs] ([id], [meeting_id], [meeting_name], [midas_id], [user_type], [time], [section], [course], [session]) VALUES (2, 167, N'rfrtft', N'ajax', N'receiver', N'1397303428', N'section1', N'2014_test', N'2014')
INSERT [dbo].[ple_meeting_invites_logs] ([id], [meeting_id], [meeting_name], [midas_id], [user_type], [time], [section], [course], [session]) VALUES (3, 167, N'rfrtft', N'anuj', N'receiver', N'1397303428', N'section1', N'2014_test', N'2014')
INSERT [dbo].[ple_meeting_invites_logs] ([id], [meeting_id], [meeting_name], [midas_id], [user_type], [time], [section], [course], [session]) VALUES (4, 167, N'rfrtft', N'jenis', N'sender', N'1397303428', N'section1', N'2014_test', N'2014')
INSERT [dbo].[ple_meeting_invites_logs] ([id], [meeting_id], [meeting_name], [midas_id], [user_type], [time], [section], [course], [session]) VALUES (5, 168, N'b v', N'sanjay', N'receiver', N'1397543034', N'section1', N'2014_test', N'2014')
INSERT [dbo].[ple_meeting_invites_logs] ([id], [meeting_id], [meeting_name], [midas_id], [user_type], [time], [section], [course], [session]) VALUES (6, 168, N'b v', N'tarun', N'sender', N'1397543034', N'section1', N'2014_test', N'2014')
SET IDENTITY_INSERT [dbo].[ple_meeting_invites_logs] OFF
/****** Object:  Table [dbo].[ple_forum_subscription_setting]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_forum_subscription_setting](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[user_id] [varchar](255) NOT NULL,
	[user_coursename] [varchar](255) NOT NULL,
	[user_sectionname] [varchar](255) NOT NULL,
	[contentpage_id] [varchar](255) NOT NULL,
	[setting_value] [bit] NOT NULL,
	[subscription_type] [int] NOT NULL,
 CONSTRAINT [PK_ple_forum_subscription_setting] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'0=>if user does not want notification, 1=> user wants notification' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'ple_forum_subscription_setting', @level2type=N'COLUMN',@level2name=N'setting_value'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'0=>''Email Notification'', 1=>will do further for other' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'ple_forum_subscription_setting', @level2type=N'COLUMN',@level2name=N'subscription_type'
GO
SET IDENTITY_INSERT [dbo].[ple_forum_subscription_setting] ON
INSERT [dbo].[ple_forum_subscription_setting] ([id], [user_id], [user_coursename], [user_sectionname], [contentpage_id], [setting_value], [subscription_type]) VALUES (29, N'sanjay', N'2014_test', N'section1', N'content1', 1, 0)
INSERT [dbo].[ple_forum_subscription_setting] ([id], [user_id], [user_coursename], [user_sectionname], [contentpage_id], [setting_value], [subscription_type]) VALUES (30, N'tarun', N'2014_test', N'section1', N'content1', 1, 0)
INSERT [dbo].[ple_forum_subscription_setting] ([id], [user_id], [user_coursename], [user_sectionname], [contentpage_id], [setting_value], [subscription_type]) VALUES (31, N'priya', N'2014_test', N'section2', N'content3', 1, 0)
INSERT [dbo].[ple_forum_subscription_setting] ([id], [user_id], [user_coursename], [user_sectionname], [contentpage_id], [setting_value], [subscription_type]) VALUES (32, N'sanjay', N'2014_test', N'section1', N'content2', 1, 0)
INSERT [dbo].[ple_forum_subscription_setting] ([id], [user_id], [user_coursename], [user_sectionname], [contentpage_id], [setting_value], [subscription_type]) VALUES (33, N'richa', N'2014_test', N'section2', N'content3', 1, 0)
INSERT [dbo].[ple_forum_subscription_setting] ([id], [user_id], [user_coursename], [user_sectionname], [contentpage_id], [setting_value], [subscription_type]) VALUES (34, N'sanjay', N'2014_test', N'section1', N'content3', 1, 0)
SET IDENTITY_INSERT [dbo].[ple_forum_subscription_setting] OFF
/****** Object:  Table [dbo].[ple_forum_settings]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_forum_settings](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[course] [varchar](255) NOT NULL,
	[setting_value] [int] NOT NULL,
	[contentpage_id] [varchar](255) NOT NULL,
	[section] [nchar](10) NULL,
 CONSTRAINT [PK_ple_forum_setting] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[ple_forum_settings] ON
INSERT [dbo].[ple_forum_settings] ([id], [course], [setting_value], [contentpage_id], [section]) VALUES (14, N'2014_test', 2, N'content1', N'section1  ')
INSERT [dbo].[ple_forum_settings] ([id], [course], [setting_value], [contentpage_id], [section]) VALUES (15, N'2014_test', 2, N'content1', N'section2  ')
INSERT [dbo].[ple_forum_settings] ([id], [course], [setting_value], [contentpage_id], [section]) VALUES (16, N'2014_test', 1, N'content3', N'section1  ')
INSERT [dbo].[ple_forum_settings] ([id], [course], [setting_value], [contentpage_id], [section]) VALUES (17, N'2014_test', 1, N'content3', N'section2  ')
SET IDENTITY_INSERT [dbo].[ple_forum_settings] OFF
/****** Object:  Table [dbo].[ple_dashboard_notification_reminder_logs]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_dashboard_notification_reminder_logs](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[midas_id] [varchar](255) NOT NULL,
	[time] [varchar](255) NOT NULL,
	[course] [varchar](255) NOT NULL,
	[section] [varchar](255) NOT NULL,
	[session] [varchar](255) NOT NULL,
 CONSTRAINT [PK_ple_dashboard_notification_reminder_setting_logs] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[ple_dashboard_notification_reminder_logs] ON
INSERT [dbo].[ple_dashboard_notification_reminder_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (1, N'tarun', N'1397547383', N'2014_test', N'section1', N'2014')
INSERT [dbo].[ple_dashboard_notification_reminder_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (2, N'sanjay', N'1397547636', N'2014_test', N'section1', N'2014')
INSERT [dbo].[ple_dashboard_notification_reminder_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (3, N'priya', N'1397548399', N'2014_test', N'section2', N'2014')
SET IDENTITY_INSERT [dbo].[ple_dashboard_notification_reminder_logs] OFF
/****** Object:  Table [dbo].[ple_dashboard_active_setting_logs]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_dashboard_active_setting_logs](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[midas_id] [varchar](255) NOT NULL,
	[time] [varchar](255) NOT NULL,
	[course] [varchar](255) NOT NULL,
	[section] [varchar](255) NOT NULL,
	[session] [varchar](255) NOT NULL,
	[type] [int] NOT NULL,
 CONSTRAINT [PK_ple_dashboard_active_setting_logs] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[ple_dashboard_active_setting_logs] ON
INSERT [dbo].[ple_dashboard_active_setting_logs] ([id], [midas_id], [time], [course], [section], [session], [type]) VALUES (1, N'tarun', N'1397544881', N'2014_test', N'section1', N'2014', 1)
INSERT [dbo].[ple_dashboard_active_setting_logs] ([id], [midas_id], [time], [course], [section], [session], [type]) VALUES (2, N'tarun', N'1397544897', N'2014_test', N'section1', N'2014', 0)
INSERT [dbo].[ple_dashboard_active_setting_logs] ([id], [midas_id], [time], [course], [section], [session], [type]) VALUES (3, N'tarun', N'1397546135', N'2014_test', N'section1', N'2014', 0)
INSERT [dbo].[ple_dashboard_active_setting_logs] ([id], [midas_id], [time], [course], [section], [session], [type]) VALUES (4, N'tarun', N'1397546139', N'2014_test', N'section1', N'2014', 1)
INSERT [dbo].[ple_dashboard_active_setting_logs] ([id], [midas_id], [time], [course], [section], [session], [type]) VALUES (5, N'tarun', N'1397546140', N'2014_test', N'section1', N'2014', 1)
INSERT [dbo].[ple_dashboard_active_setting_logs] ([id], [midas_id], [time], [course], [section], [session], [type]) VALUES (6, N'tarun', N'1397546141', N'2014_test', N'section1', N'2014', 1)
INSERT [dbo].[ple_dashboard_active_setting_logs] ([id], [midas_id], [time], [course], [section], [session], [type]) VALUES (7, N'tarun', N'1397546142', N'2014_test', N'section1', N'2014', 1)
INSERT [dbo].[ple_dashboard_active_setting_logs] ([id], [midas_id], [time], [course], [section], [session], [type]) VALUES (8, N'tarun', N'1397546146', N'2014_test', N'section1', N'2014', 0)
INSERT [dbo].[ple_dashboard_active_setting_logs] ([id], [midas_id], [time], [course], [section], [session], [type]) VALUES (9, N'tarun', N'1397546148', N'2014_test', N'section1', N'2014', 0)
INSERT [dbo].[ple_dashboard_active_setting_logs] ([id], [midas_id], [time], [course], [section], [session], [type]) VALUES (10, N'tarun', N'1397546154', N'2014_test', N'section1', N'2014', 0)
INSERT [dbo].[ple_dashboard_active_setting_logs] ([id], [midas_id], [time], [course], [section], [session], [type]) VALUES (11, N'tarun', N'1397546157', N'2014_test', N'section1', N'2014', 1)
INSERT [dbo].[ple_dashboard_active_setting_logs] ([id], [midas_id], [time], [course], [section], [session], [type]) VALUES (12, N'sanjay', N'1397547629', N'2014_test', N'section1', N'2014', 1)
INSERT [dbo].[ple_dashboard_active_setting_logs] ([id], [midas_id], [time], [course], [section], [session], [type]) VALUES (13, N'priya', N'1397548387', N'2014_test', N'section2', N'2014', 1)
INSERT [dbo].[ple_dashboard_active_setting_logs] ([id], [midas_id], [time], [course], [section], [session], [type]) VALUES (14, N'priya', N'1397548390', N'2014_test', N'section2', N'2014', 0)
SET IDENTITY_INSERT [dbo].[ple_dashboard_active_setting_logs] OFF
/****** Object:  Table [dbo].[ple_current_online_user_logs]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_current_online_user_logs](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[midas_id] [varchar](255) NOT NULL,
	[time] [varchar](255) NOT NULL,
	[course] [varchar](255) NOT NULL,
	[section] [varchar](255) NOT NULL,
	[session] [varchar](255) NOT NULL,
 CONSTRAINT [PK_ple_current_online_user_logs] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[ple_current_online_user_logs] ON
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (5, N'sanjay', N'1397542901', N'2014_test', N'section1', N'2014')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (9, N'tarun', N'1397542889', N'2014_test', N'section1', N'2014')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (14, N'ajax', N'1396954175', N'2014_test', N'section1', N'2014')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (15, N'chris', N'1397286941', N'2014_test', N'section2 ', N'2014')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (16, N'abhi', N'1396956019', N'2014_test', N'section1', N'2014')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (17, N'anuj', N'1396953079', N'2014_test', N'section1 ', N'2014')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (18, N'asha', N'1396953206', N'2014_test1', N'section1', N'2014')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (19, N'bob', N'1396954263', N'2014_test1', N'section1', N'2014')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (20, N'charls', N'1396955421', N'2014_test', N'section1', N'2014')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (21, N'yogi', N'1396958945', N'2015_test', N'section1', N'2015')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (22, N'sandy', N'1396955977', N'2015_test', N'section2', N'2015')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (23, N'dexter', N'1396975476', N'2014_test1', N'section1', N'2014')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (24, N'dan', N'1396973505', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (25, N'awxmb8jeit', N'1396974127', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (26, N'qjgbjiwyix', N'1396975002', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (27, N'c7bc3nerwx', N'1396974145', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (28, N'9ymtyjsptd', N'1396974149', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (29, N'zdjongtrnf', N'1396974151', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (30, N'q9y3whnmc3', N'1396974180', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (31, N'jompkgnhz5', N'1396974984', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (32, N'y8agbzayxg', N'1396974190', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (33, N'vgglne2dsg', N'1396974195', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (34, N'hka2hpzcio', N'1396974202', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (35, N'ovrzt7ush0', N'1396974220', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (36, N'i7ruer3hcn', N'1396974232', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (37, N'uo8ybu6hfe', N'1396974233', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (38, N'hxgxf3ld9p', N'1396974235', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (39, N'rg7hejsba3', N'1396974240', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (40, N'xi9spmowa0', N'1396974459', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (41, N'jxkmexva7w', N'1396974828', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (42, N'np17qifhgp', N'1396974331', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (43, N'macuser1', N'1396974378', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (44, N'ztdsnl6vgl', N'1396974381', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (45, N'ebjv70iwln', N'1396974474', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (46, N'loky31fzw3', N'1396974477', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (47, N'muadhsl8j9', N'1396974479', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (48, N'ub9diu7cbe', N'1396974538', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (49, N'j2gp6ej6d7', N'1396974536', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (50, N'oz6xswkuui', N'1396974545', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (51, N'c66gedfyux', N'1396975936', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (52, N'a4htdsz3k0', N'1396974583', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (53, N'wpkbwvaduh', N'1396974585', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (54, N'swqqiej5dp', N'1396974588', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (55, N'drsczj3iz4', N'1396974637', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (56, N'gh2uosldxo', N'1396974638', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (57, N'pl5a7evtmw', N'1396974641', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (58, N'dr4pqc0k3a', N'1396974682', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (59, N'64drrdo8mb', N'1396974686', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (60, N'kkozcmrscn', N'1396974691', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (61, N'skk1lw1kw1', N'1396974790', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (62, N'3eg3pferwl', N'1396974718', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (63, N'jkkrudrlxx', N'1396976049', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (64, N'lastpc', N'1396974754', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (65, N'ekbstj0yre', N'1396974757', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (66, N'fiynbwodea', N'1396974762', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (67, N'johnv', N'1396975466', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (68, N'johnv', N'1396975347', N'plecourse', N'section2', N'plecourse-section2')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (69, N'asdfasdfa', N'1396975887', N'plecourse', N'section2', N'plecourse-section2')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (70, N'ashley', N'1396975521', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (71, N'morgan', N'1396975479', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (72, N'anita', N'1396976742', N'plecourse', N'section1', N'plecourse-section1')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (73, N'daniel', N'1397016888', N'2014_test', N'section1', N'2014')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (74, N'priya', N'1397286914', N'2014_test', N'section2', N'2014')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (75, N'richa', N'1397286924', N'2014_test', N'section2', N'2014')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (76, N'rinky', N'1397286961', N'2014_test1', N'section1', N'2014')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (77, N'shalu', N'1397296052', N'2014_test1', N'section1', N'2014')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (78, N'amrita', N'1397303209', N'2014_test1', N'section1', N'2014')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (79, N'ruby', N'1397303227', N'2014_test1', N'section2', N'2014')
INSERT [dbo].[ple_current_online_user_logs] ([id], [midas_id], [time], [course], [section], [session]) VALUES (80, N'jenis', N'1397303411', N'2014_test', N'section1', N'2014')
SET IDENTITY_INSERT [dbo].[ple_current_online_user_logs] OFF
/****** Object:  Table [dbo].[ple_contentpage_topic]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_contentpage_topic](
	[id] [int] NOT NULL,
	[contentpage_id] [varchar](255) NULL,
	[topic_name] [varchar](255) NULL,
 CONSTRAINT [PK_ple_contentpage_topic] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
INSERT [dbo].[ple_contentpage_topic] ([id], [contentpage_id], [topic_name]) VALUES (1, N'content1', N'topic1')
INSERT [dbo].[ple_contentpage_topic] ([id], [contentpage_id], [topic_name]) VALUES (2, N'content2', N'topic2')
INSERT [dbo].[ple_contentpage_topic] ([id], [contentpage_id], [topic_name]) VALUES (3, N'content2', N'topic3')
/****** Object:  Table [dbo].[ple_contentpage_setting]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_contentpage_setting](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[contentpage_id] [varchar](255) NOT NULL,
	[start_date] [varchar](255) NULL,
	[end_date] [varchar](255) NULL,
	[instructor_id] [varchar](255) NULL,
	[course] [varchar](255) NULL,
	[section] [varchar](255) NULL,
	[rstart_date] [varchar](255) NULL,
	[rend_date] [varchar](255) NULL,
 CONSTRAINT [PK_ple_contentpage_setting] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[ple_contentpage_setting] ON
INSERT [dbo].[ple_contentpage_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section], [rstart_date], [rend_date]) VALUES (33, N'content1', N'0', N'2020426106', N'tarun', N'test', N'section1', N'0', N'2020426106')
INSERT [dbo].[ple_contentpage_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section], [rstart_date], [rend_date]) VALUES (34, N'content1', N'0', N'2020426106', N'richa', N'test', N'section2', N'0', N'2020426106')
INSERT [dbo].[ple_contentpage_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section], [rstart_date], [rend_date]) VALUES (35, N'content2', N'0', N'2020426106', N'priya', N'test', N'section2', N'0', N'2020426106')
INSERT [dbo].[ple_contentpage_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section], [rstart_date], [rend_date]) VALUES (36, N'content4', N'0', N'2020426106', N'priya', N'test', N'section2', N'0', N'2020426106')
INSERT [dbo].[ple_contentpage_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section], [rstart_date], [rend_date]) VALUES (37, N'content3', N'0', N'2020426106', N'priya', N'test', N'section2', N'0', N'2020426106')
INSERT [dbo].[ple_contentpage_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section], [rstart_date], [rend_date]) VALUES (38, N'content2', N'0', N'2020426106', N'tarun', N'test', N'section1', N'0', N'2020426106')
INSERT [dbo].[ple_contentpage_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section], [rstart_date], [rend_date]) VALUES (39, N'content3', N'0', N'2020426106', N'tarun', N'test', N'section1', N'0', N'2020426106')
INSERT [dbo].[ple_contentpage_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section], [rstart_date], [rend_date]) VALUES (40, N'content4', N'0', N'2020426106', N'tarun', N'test', N'section1', N'0', N'2020426106')
INSERT [dbo].[ple_contentpage_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section], [rstart_date], [rend_date]) VALUES (41, N'content1', N'0', N'2020426106', N'marry', N'plecourse', N'section1', N'0', N'2020426106')
INSERT [dbo].[ple_contentpage_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section], [rstart_date], [rend_date]) VALUES (42, N'content2', N'0', N'2020426106', N'marry', N'plecourse', N'section1', N'0', N'2020426106')
INSERT [dbo].[ple_contentpage_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section], [rstart_date], [rend_date]) VALUES (43, N'content3', N'0', N'2020426106', N'marry', N'plecourse', N'section1', N'0', N'2020426106')
INSERT [dbo].[ple_contentpage_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section], [rstart_date], [rend_date]) VALUES (44, N'content1', N'0', N'2020426106', N'sandy', N'plecourse', N'section2', N'0', N'2020426106')
INSERT [dbo].[ple_contentpage_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section], [rstart_date], [rend_date]) VALUES (45, N'content2', N'0', N'2020426106', N'sandy', N'plecourse', N'section2', N'0', N'2020426106')
INSERT [dbo].[ple_contentpage_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section], [rstart_date], [rend_date]) VALUES (46, N'content3', N'0', N'2020426106', N'sandy', N'plecourse', N'section2', N'0', N'2020426106')
INSERT [dbo].[ple_contentpage_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section], [rstart_date], [rend_date]) VALUES (47, N'content4', N'0', N'2020426106', N'sandy', N'plecourse', N'section2', N'0', N'2020426106')
INSERT [dbo].[ple_contentpage_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section], [rstart_date], [rend_date]) VALUES (48, N'content1', N'0', N'2020426106', N'tarun', N'test', N'section1', N'0', N'2020426106')
INSERT [dbo].[ple_contentpage_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section], [rstart_date], [rend_date]) VALUES (49, N'content1', N'0', N'2020426106', N'priya', N'2014_test', N'section', N'0', N'2020426106')
INSERT [dbo].[ple_contentpage_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section], [rstart_date], [rend_date]) VALUES (50, N'content1', N'0', N'2020426106', N'priya', N'2014_test', N'section2', N'0', N'2020426106')
INSERT [dbo].[ple_contentpage_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section], [rstart_date], [rend_date]) VALUES (51, N'content1', N'0', N'2020426106', N'tarun', N'2014_test', N'section1', N'0', N'2020426106')
INSERT [dbo].[ple_contentpage_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section], [rstart_date], [rend_date]) VALUES (52, N'content2', N'0', N'2020426106', N'tarun', N'2014_test', N'section1', N'0', N'2020426106')
INSERT [dbo].[ple_contentpage_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section], [rstart_date], [rend_date]) VALUES (53, N'content3', N'0', N'2020426106', N'tarun', N'2014_test', N'section1', N'0', N'2020426106')
INSERT [dbo].[ple_contentpage_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section], [rstart_date], [rend_date]) VALUES (54, N'content3', N'0', N'2020426106', N'priya', N' 2014_test', N'section2', N'0', N'2020426106')
INSERT [dbo].[ple_contentpage_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section], [rstart_date], [rend_date]) VALUES (55, N'content3', N'0', N'2020426106', N'richa', N'2014_test', N'section2', N'0', N'2020426106')
SET IDENTITY_INSERT [dbo].[ple_contentpage_setting] OFF
/****** Object:  Table [dbo].[ple_contentpage_ro_setting]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_contentpage_ro_setting](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[contentpage_id] [varchar](225) NULL,
	[start_date] [varchar](225) NULL,
	[end_date] [varchar](225) NULL,
	[instructor_id] [varchar](225) NULL,
	[course] [varchar](225) NULL,
	[section] [varchar](225) NULL,
 CONSTRAINT [PK_ple_contentpage_ro_setting] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[ple_contentpage_ro_setting] ON
INSERT [dbo].[ple_contentpage_ro_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section]) VALUES (29, N'content1', N'0', N'0', N'tarun', N'test', N'section1')
INSERT [dbo].[ple_contentpage_ro_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section]) VALUES (30, N'content1', N'0', N'0', N'richa', N'test', N'section2')
INSERT [dbo].[ple_contentpage_ro_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section]) VALUES (31, N'content2', N'0', N'0', N'priya', N'test', N'section2')
INSERT [dbo].[ple_contentpage_ro_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section]) VALUES (32, N'content4', N'0', N'0', N'priya', N'test', N'section2')
INSERT [dbo].[ple_contentpage_ro_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section]) VALUES (33, N'content3', N'0', N'0', N'priya', N'test', N'section2')
INSERT [dbo].[ple_contentpage_ro_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section]) VALUES (34, N'content2', N'0', N'0', N'tarun', N'test', N'section1')
INSERT [dbo].[ple_contentpage_ro_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section]) VALUES (35, N'content3', N'0', N'0', N'tarun', N'test', N'section1')
INSERT [dbo].[ple_contentpage_ro_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section]) VALUES (36, N'content4', N'0', N'0', N'tarun', N'test', N'section1')
INSERT [dbo].[ple_contentpage_ro_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section]) VALUES (37, N'content1', N'0', N'0', N'marry', N'plecourse', N'section1')
INSERT [dbo].[ple_contentpage_ro_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section]) VALUES (38, N'content1', N'0', N'0', N'tarun', N'test', N'sewction1')
INSERT [dbo].[ple_contentpage_ro_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section]) VALUES (39, N'content2', N'0', N'0', N'john', N'plecourse', N'section1')
INSERT [dbo].[ple_contentpage_ro_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section]) VALUES (40, N'content2', N'0', N'0', N'daniel', N'plecourse', N'section2')
INSERT [dbo].[ple_contentpage_ro_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section]) VALUES (41, N'content3', N'0', N'0', N'daniel', N'plecourse', N'section2')
INSERT [dbo].[ple_contentpage_ro_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section]) VALUES (42, N'content4', N'0', N'0', N'daniel', N'plecourse', N'section2')
INSERT [dbo].[ple_contentpage_ro_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section]) VALUES (43, N'content1', N'0', N'0', N'priya', N'2014_test', N'section')
INSERT [dbo].[ple_contentpage_ro_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section]) VALUES (44, N'content1', N'0', N'0', N'priya', N'2014_test', N'section2')
INSERT [dbo].[ple_contentpage_ro_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section]) VALUES (45, N'content1', N'0', N'0', N'tarun', N'2014_test', N'section1')
INSERT [dbo].[ple_contentpage_ro_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section]) VALUES (46, N'content2', N'0', N'0', N'tarun', N'2014_test', N'section1')
INSERT [dbo].[ple_contentpage_ro_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section]) VALUES (47, N'content3', N'0', N'0', N'tarun', N'2014_test', N'section1')
INSERT [dbo].[ple_contentpage_ro_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section]) VALUES (48, N'content3', N'0', N'0', N'priya', N' 2014_test', N'section2')
INSERT [dbo].[ple_contentpage_ro_setting] ([id], [contentpage_id], [start_date], [end_date], [instructor_id], [course], [section]) VALUES (49, N'content3', N'0', N'0', N'richa', N'2014_test', N'section2')
SET IDENTITY_INSERT [dbo].[ple_contentpage_ro_setting] OFF
/****** Object:  Table [dbo].[ple_content_page_structure1]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_content_page_structure1](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[course_id] [varchar](255) NOT NULL,
	[module_id] [varchar](255) NULL,
	[topic_id] [varchar](255) NULL,
	[content_page_id] [varchar](255) NULL,
 CONSTRAINT [PK_ple_contentpage_structure] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[ple_content_page_structure1] ON
INSERT [dbo].[ple_content_page_structure1] ([id], [course_id], [module_id], [topic_id], [content_page_id]) VALUES (1, N'2014_test-section1', N'module1', N'topic1', N'content1')
INSERT [dbo].[ple_content_page_structure1] ([id], [course_id], [module_id], [topic_id], [content_page_id]) VALUES (2, N'2014_test-section1', N'module1', N'topic1', N'content2')
INSERT [dbo].[ple_content_page_structure1] ([id], [course_id], [module_id], [topic_id], [content_page_id]) VALUES (3, N'2014_test-section1', N'module1', N'topic1', N'content3')
INSERT [dbo].[ple_content_page_structure1] ([id], [course_id], [module_id], [topic_id], [content_page_id]) VALUES (4, N'2014_test-section1', N'module1', N'topic2', N'content4')
INSERT [dbo].[ple_content_page_structure1] ([id], [course_id], [module_id], [topic_id], [content_page_id]) VALUES (5, N'2014_test-section1', N'module2', N'topic1', N'content5')
INSERT [dbo].[ple_content_page_structure1] ([id], [course_id], [module_id], [topic_id], [content_page_id]) VALUES (6, N'2014_test-section1', N'module2', N'topic1', N'content6')
INSERT [dbo].[ple_content_page_structure1] ([id], [course_id], [module_id], [topic_id], [content_page_id]) VALUES (7, N'2014_test-section1', NULL, NULL, N'content7')
INSERT [dbo].[ple_content_page_structure1] ([id], [course_id], [module_id], [topic_id], [content_page_id]) VALUES (8, N'2014_test-section1', N'module2', NULL, N'content8')
INSERT [dbo].[ple_content_page_structure1] ([id], [course_id], [module_id], [topic_id], [content_page_id]) VALUES (9, N'2014_test-section1', NULL, NULL, N'content9')
INSERT [dbo].[ple_content_page_structure1] ([id], [course_id], [module_id], [topic_id], [content_page_id]) VALUES (10, N'2014_test-section1', N'module2', NULL, N'content10')
SET IDENTITY_INSERT [dbo].[ple_content_page_structure1] OFF
/****** Object:  Table [dbo].[ple_content_page_structure]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_content_page_structure](
	[content_page_uuid] [varchar](255) NOT NULL,
	[course_id] [varchar](255) NOT NULL,
	[module_uuid] [varchar](255) NULL,
	[module_title] [varchar](255) NULL,
	[topic_uuid] [varchar](255) NULL,
	[topic_title] [varchar](255) NULL,
	[content_page_title] [varchar](255) NOT NULL,
 CONSTRAINT [PK_ple_content_page_structure] PRIMARY KEY CLUSTERED 
(
	[content_page_uuid] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
INSERT [dbo].[ple_content_page_structure] ([content_page_uuid], [course_id], [module_uuid], [module_title], [topic_uuid], [topic_title], [content_page_title]) VALUES (N'content1', N'2014_test-section1', N'module1', N'module_one', N'topic1', N'topic_one', N'contentpage_one')
INSERT [dbo].[ple_content_page_structure] ([content_page_uuid], [course_id], [module_uuid], [module_title], [topic_uuid], [topic_title], [content_page_title]) VALUES (N'content10', N'2014_test-section1', NULL, NULL, NULL, NULL, N'contentpage_ten')
INSERT [dbo].[ple_content_page_structure] ([content_page_uuid], [course_id], [module_uuid], [module_title], [topic_uuid], [topic_title], [content_page_title]) VALUES (N'content11', N'2014_test-section1', N'module3', N'module_three', N'topic5', N'topic_five', N'contentpage_eleven')
INSERT [dbo].[ple_content_page_structure] ([content_page_uuid], [course_id], [module_uuid], [module_title], [topic_uuid], [topic_title], [content_page_title]) VALUES (N'content2', N'2014_test-section1', N'module1', N'module_one', N'topic1', N'topic_one', N'contentpage_two')
INSERT [dbo].[ple_content_page_structure] ([content_page_uuid], [course_id], [module_uuid], [module_title], [topic_uuid], [topic_title], [content_page_title]) VALUES (N'content3', N'2014_test-section1', N'module1', N'module_one', N'topic2', N'topic_two', N'contentpage_three')
INSERT [dbo].[ple_content_page_structure] ([content_page_uuid], [course_id], [module_uuid], [module_title], [topic_uuid], [topic_title], [content_page_title]) VALUES (N'content4', N'2014_test-section1', N'module2', N'module_two', N'topic4', N'topic_four', N'contentpage_four')
INSERT [dbo].[ple_content_page_structure] ([content_page_uuid], [course_id], [module_uuid], [module_title], [topic_uuid], [topic_title], [content_page_title]) VALUES (N'content5', N'2014_test-section1', N'module2', N'module_two', N'topic3', N'topic_three', N'contentpage_five')
INSERT [dbo].[ple_content_page_structure] ([content_page_uuid], [course_id], [module_uuid], [module_title], [topic_uuid], [topic_title], [content_page_title]) VALUES (N'content6', N'2014_test-section1', NULL, NULL, NULL, NULL, N'contentpage_six')
INSERT [dbo].[ple_content_page_structure] ([content_page_uuid], [course_id], [module_uuid], [module_title], [topic_uuid], [topic_title], [content_page_title]) VALUES (N'content7', N'2014_test-section1', N'module2', N'module_two', NULL, NULL, N'contentpage_seven')
INSERT [dbo].[ple_content_page_structure] ([content_page_uuid], [course_id], [module_uuid], [module_title], [topic_uuid], [topic_title], [content_page_title]) VALUES (N'content8', N'2014_test-section1', N'module2', N'module_two', NULL, NULL, N'contentpage_eight')
INSERT [dbo].[ple_content_page_structure] ([content_page_uuid], [course_id], [module_uuid], [module_title], [topic_uuid], [topic_title], [content_page_title]) VALUES (N'content9', N'2014_test-section1', NULL, NULL, NULL, NULL, N'contentpage_nine')
/****** Object:  Table [dbo].[ple_comment_rating]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_comment_rating](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[question_id] [int] NOT NULL,
	[comment_id] [int] NOT NULL,
	[rate_by] [varchar](255) NULL,
	[rate] [int] NULL,
	[date] [varchar](255) NULL,
	[course_name] [varchar](255) NULL,
	[section_name] [varchar](255) NULL,
	[content_page_id] [varchar](255) NULL,
 CONSTRAINT [PK_ple_comment_rating] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[ple_chat_session_logs]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_chat_session_logs](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[chat_id] [int] NOT NULL,
	[chat_name] [varchar](255) NOT NULL,
	[midas_id] [varchar](255) NOT NULL,
	[time] [varchar](255) NOT NULL,
	[course] [varchar](255) NOT NULL,
	[section] [varchar](255) NOT NULL,
	[session] [varchar](255) NOT NULL,
	[type] [varchar](255) NOT NULL,
	[chat_type] [int] NOT NULL,
 CONSTRAINT [PK_ple_chat_session_logs] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[ple_chat_session_logs] ON
INSERT [dbo].[ple_chat_session_logs] ([id], [chat_id], [chat_name], [midas_id], [time], [course], [section], [session], [type], [chat_type]) VALUES (1, 1990, N'roomid_1397542903', N'sanjay', N'1397542903', N'2014_test', N'section1', N'2014', N'owner', 1)
INSERT [dbo].[ple_chat_session_logs] ([id], [chat_id], [chat_name], [midas_id], [time], [course], [section], [session], [type], [chat_type]) VALUES (2, 344, N'roomid_1396955577', N'tarun', N'1397543072', N'2014_test', N'section1', N'2014', N'owner', 0)
INSERT [dbo].[ple_chat_session_logs] ([id], [chat_id], [chat_name], [midas_id], [time], [course], [section], [session], [type], [chat_type]) VALUES (3, 362, N'roomid_1397543027', N'sanjay', N'1397543104', N'2014_test', N'section1', N'2014', N'owner', 0)
INSERT [dbo].[ple_chat_session_logs] ([id], [chat_id], [chat_name], [midas_id], [time], [course], [section], [session], [type], [chat_type]) VALUES (4, 363, N'roomid_1397543027', N'tarun', N'1397543125', N'2014_test', N'section1', N'2014', N'receiver', 0)
SET IDENTITY_INSERT [dbo].[ple_chat_session_logs] OFF
/****** Object:  Table [dbo].[ple_assignment_twitter_failure]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_assignment_twitter_failure](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[twitter_id] [varchar](255) NOT NULL,
	[mail_data] [text] NOT NULL,
 CONSTRAINT [PK_ple_assignment_twitter_failure] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[ple_assignment_twitter_failure] ON
INSERT [dbo].[ple_assignment_twitter_failure] ([id], [twitter_id], [mail_data]) VALUES (26, N'0', N'AssignMent Reminder! 2014_test-section2. Your assignment, Section 1.10.33 of "de Finibus Bonorum et Malorum", written by Cicero in 45 BC,  due on March 26, 2014.')
INSERT [dbo].[ple_assignment_twitter_failure] ([id], [twitter_id], [mail_data]) VALUES (27, N'0', N'AssignMent Reminder! 2014_test-section2. Your assignment, chapter3,  due on April 02, 2014.')
INSERT [dbo].[ple_assignment_twitter_failure] ([id], [twitter_id], [mail_data]) VALUES (28, N'0', N'AssignMent Reminder! 2014_test-section2. Your assignment, chapter4,  due on April 29, 2014.')
INSERT [dbo].[ple_assignment_twitter_failure] ([id], [twitter_id], [mail_data]) VALUES (29, N'0', N'AssignMent Reminder! 2014_test-section2. Your assignment, chapter6,  due on April 21, 2014.')
SET IDENTITY_INSERT [dbo].[ple_assignment_twitter_failure] OFF
/****** Object:  Table [dbo].[ple_assignment_reminder_log]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_assignment_reminder_log](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[midas_id] [varchar](225) NOT NULL,
	[time] [varchar](225) NOT NULL,
	[course] [varchar](225) NOT NULL,
	[section] [varchar](225) NOT NULL,
	[session] [varchar](225) NOT NULL,
 CONSTRAINT [PK_ple_assignment_reminder_log] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[ple_assignment_reminder_log] ON
INSERT [dbo].[ple_assignment_reminder_log] ([id], [midas_id], [time], [course], [section], [session]) VALUES (1, N'tarun', N'1397549086', N'2014_test', N'section1', N'2014')
INSERT [dbo].[ple_assignment_reminder_log] ([id], [midas_id], [time], [course], [section], [session]) VALUES (2, N'sanjay', N'1397549092', N'2014_test', N'section1', N'2014')
INSERT [dbo].[ple_assignment_reminder_log] ([id], [midas_id], [time], [course], [section], [session]) VALUES (3, N'sanjay', N'1397549103', N'2014_test', N'section1', N'2014')
INSERT [dbo].[ple_assignment_reminder_log] ([id], [midas_id], [time], [course], [section], [session]) VALUES (4, N'priya', N'1397549104', N'2014_test', N'section2', N'2014')
INSERT [dbo].[ple_assignment_reminder_log] ([id], [midas_id], [time], [course], [section], [session]) VALUES (5, N'sanjay', N'1397549110', N'2014_test', N'section1', N'2014')
SET IDENTITY_INSERT [dbo].[ple_assignment_reminder_log] OFF
/****** Object:  Table [dbo].[ple_assignment_reminder]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_assignment_reminder](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[course_id] [varchar](40) NULL,
	[assignment_uuid] [varchar](255) NULL,
	[user_id] [varchar](40) NULL,
	[assignment_title] [varchar](255) NULL,
	[due_date] [datetime] NULL,
	[remind_week_before] [tinyint] NOT NULL,
	[remind_day_before] [tinyint] NOT NULL,
	[remind_day_of] [tinyint] NOT NULL,
	[remind_custom_date] [datetime] NULL,
 CONSTRAINT [PK_ple_assignment_reminder] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[ple_assignment_reminder] ON
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (1, N'2014_test-section1', N'asg1', N'tarun', N'Section 1.10.33 of "de Finibus Bonorum et Malorum", written by Cicero in 45 BC', CAST(0x0000A31900000000 AS DateTime), 0, 0, 1, CAST(0x0000A30E00000000 AS DateTime))
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (2, N'2014_test-section1', N'asg2', N'tarun', N'chapter2', CAST(0x0000A31A00000000 AS DateTime), 0, 1, 0, NULL)
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (3, N'2014_test-section1', N'asg3', N'tarun', N'chapter3', CAST(0x0000A30E00000000 AS DateTime), 1, 1, 1, CAST(0x0000A30800000000 AS DateTime))
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (4, N'2014_test-section1', N'asg4', N'tarun', N'chapter4', CAST(0x0000A30D00000000 AS DateTime), 1, 1, 1, CAST(0x0000A30800000000 AS DateTime))
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (5, N'2014_test-section1', N'asg5', N'tarun', N'chapter5', CAST(0x0000A30F00000000 AS DateTime), 0, 0, 0, CAST(0x0000A2FA00000000 AS DateTime))
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (6, N'2014_test-section1', N'asg6', N'tarun', N'chapter6', CAST(0x0000A31000000000 AS DateTime), 0, 0, 0, NULL)
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (7, N'2014_test-section1', N'asg7', N'tarun', N'chapter7', CAST(0x0000A31100000000 AS DateTime), 0, 0, 0, NULL)
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (8, N'2014_test-section1', N'asg8', N'tarun', N'chapter8', CAST(0x0000A31200000000 AS DateTime), 0, 0, 0, NULL)
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (9, N'2014_test-section1', N'asg9', N'tarun', N'chapter9', NULL, 0, 0, 0, CAST(0x0000A30800000000 AS DateTime))
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (10, N'2014_test-section2', N'asg1', N'priya', N'Section 1.10.33 of "de Finibus Bonorum et Malorum", written by Cicero in 45 BC', CAST(0x0000A31900000000 AS DateTime), 1, 1, 1, CAST(0x0000A2FA00000000 AS DateTime))
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (11, N'2014_test-section2', N'asg2', N'priya', N'chapter2', CAST(0x0000A31A00000000 AS DateTime), 0, 0, 0, NULL)
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (12, N'2014_test-section2', N'asg3', N'priya', N'chapter3', CAST(0x0000A30E00000000 AS DateTime), 1, 1, 1, CAST(0x0000A2FA00000000 AS DateTime))
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (13, N'2014_test-section2', N'asg4', N'priya', N'chapter4', CAST(0x0000A30D00000000 AS DateTime), 1, 1, 1, CAST(0x0000A2FA00000000 AS DateTime))
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (14, N'2014_test-section2', N'asg5', N'priya', N'chapter5', CAST(0x0000A30F00000000 AS DateTime), 0, 0, 1, CAST(0x0000A2FB00000000 AS DateTime))
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (15, N'2014_test-section2', N'asg6', N'priya', N'chapter6', CAST(0x0000A31000000000 AS DateTime), 0, 0, 1, CAST(0x0000A2FA00000000 AS DateTime))
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (16, N'2014_test-section2', N'asg7', N'priya', N'chapter7', CAST(0x0000A31100000000 AS DateTime), 1, 1, 1, CAST(0x0000A30F00000000 AS DateTime))
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (17, N'2014_test-section2', N'asg8', N'priya', N'chapter8', CAST(0x0000A31200000000 AS DateTime), 0, 0, 1, NULL)
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (18, N'2014_test-section2', N'asg9', N'priya', N'chapter9', NULL, 0, 0, 0, NULL)
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (19, N'2014_test-section1', N'asg1', N'sanjay', N'Section 1.10.33 of "de Finibus Bonorum et Malorum", written by Cicero in 45 BC', CAST(0x0000A31900000000 AS DateTime), 0, 1, 1, NULL)
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (20, N'2014_test-section1', N'asg2', N'sanjay', N'chapter2', CAST(0x0000A31A00000000 AS DateTime), 0, 0, 0, NULL)
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (21, N'2014_test-section1', N'asg3', N'sanjay', N'chapter3', CAST(0x0000A30E00000000 AS DateTime), 0, 0, 0, NULL)
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (22, N'2014_test-section1', N'asg4', N'sanjay', N'chapter4', CAST(0x0000A30D00000000 AS DateTime), 0, 0, 0, NULL)
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (23, N'2014_test-section1', N'asg5', N'sanjay', N'chapter5', CAST(0x0000A30F00000000 AS DateTime), 0, 0, 0, NULL)
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (24, N'2014_test-section1', N'asg6', N'sanjay', N'chapter6', CAST(0x0000A31000000000 AS DateTime), 0, 0, 0, NULL)
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (25, N'2014_test-section1', N'asg7', N'sanjay', N'chapter7', CAST(0x0000A31100000000 AS DateTime), 0, 0, 0, NULL)
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (26, N'2014_test-section1', N'asg8', N'sanjay', N'chapter8', CAST(0x0000A31200000000 AS DateTime), 0, 0, 0, NULL)
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (27, N'2014_test-section1', N'asg9', N'sanjay', N'chapter9', NULL, 0, 0, 0, NULL)
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (28, N'2014_test-section1', N'asg1', N'daniel', N'Section 1.10.33 of "de Finibus Bonorum et Malorum", written by Cicero in 45 BC', CAST(0x0000A31900000000 AS DateTime), 0, 0, 0, NULL)
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (29, N'2014_test-section1', N'asg2', N'daniel', N'chapter2', CAST(0x0000A31A00000000 AS DateTime), 0, 0, 0, NULL)
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (30, N'2014_test-section1', N'asg3', N'daniel', N'chapter3', CAST(0x0000A30E00000000 AS DateTime), 1, 0, 0, NULL)
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (31, N'2014_test-section1', N'asg4', N'daniel', N'chapter4', CAST(0x0000A30D00000000 AS DateTime), 0, 0, 0, CAST(0x0000A30800000000 AS DateTime))
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (32, N'2014_test-section1', N'asg5', N'daniel', N'chapter5', CAST(0x0000A30F00000000 AS DateTime), 1, 0, 0, NULL)
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (33, N'2014_test-section1', N'asg6', N'daniel', N'chapter6', CAST(0x0000A31000000000 AS DateTime), 1, 0, 0, NULL)
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (34, N'2014_test-section1', N'asg7', N'daniel', N'chapter7', CAST(0x0000A31100000000 AS DateTime), 0, 0, 0, NULL)
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (35, N'2014_test-section1', N'asg8', N'daniel', N'chapter8', CAST(0x0000A31200000000 AS DateTime), 0, 0, 0, NULL)
INSERT [dbo].[ple_assignment_reminder] ([id], [course_id], [assignment_uuid], [user_id], [assignment_title], [due_date], [remind_week_before], [remind_day_before], [remind_day_of], [remind_custom_date]) VALUES (36, N'2014_test-section1', N'asg9', N'daniel', N'chapter9', NULL, 0, 0, 0, NULL)
SET IDENTITY_INSERT [dbo].[ple_assignment_reminder] OFF
/****** Object:  Table [dbo].[ple_assignment_mail_failure]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_assignment_mail_failure](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[email] [varchar](255) NOT NULL,
	[subject] [varchar](255) NOT NULL,
	[mail_data] [text] NOT NULL,
 CONSTRAINT [PK_ple_assignment_mail_failure] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[ple_assignment_last_reminder_sent]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_assignment_last_reminder_sent](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[last_sent_rid] [bigint] NULL,
	[type] [varchar](50) NULL,
	[date] [datetime] NULL,
 CONSTRAINT [PK_ple_assignment_last_reminder_sent] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[ple_assignment_last_reminder_sent] ON
INSERT [dbo].[ple_assignment_last_reminder_sent] ([id], [last_sent_rid], [type], [date]) VALUES (181, 19, N'twitter', CAST(0x0000A2FA00000000 AS DateTime))
INSERT [dbo].[ple_assignment_last_reminder_sent] ([id], [last_sent_rid], [type], [date]) VALUES (183, 32, N'email', CAST(0x0000A30800000000 AS DateTime))
INSERT [dbo].[ple_assignment_last_reminder_sent] ([id], [last_sent_rid], [type], [date]) VALUES (185, 32, N'twitter', CAST(0x0000A30800000000 AS DateTime))
INSERT [dbo].[ple_assignment_last_reminder_sent] ([id], [last_sent_rid], [type], [date]) VALUES (187, 32, N'fb', CAST(0x0000A30800000000 AS DateTime))
SET IDENTITY_INSERT [dbo].[ple_assignment_last_reminder_sent] OFF
/****** Object:  Table [dbo].[ple_assignment_facebook_failure]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ple_assignment_facebook_failure](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[facebook_id] [varchar](255) NOT NULL,
	[mail_data] [text] NOT NULL,
 CONSTRAINT [PK_ple_assignment_facebook_failure] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[ple_assignment_facebook_failure] ON
INSERT [dbo].[ple_assignment_facebook_failure] ([id], [facebook_id], [mail_data]) VALUES (3, N'100006366398421', N'AssignMent Reminder! 201420_test_section1. Your assignment, as1_title,  due on March 17, 2014.')
INSERT [dbo].[ple_assignment_facebook_failure] ([id], [facebook_id], [mail_data]) VALUES (4, N'100006366398421', N'AssignMent Reminder! 201420_test_section1. Your assignment, as2_title,  due on March 17, 2014.')
SET IDENTITY_INSERT [dbo].[ple_assignment_facebook_failure] OFF
/****** Object:  Table [dbo].[instructor_assgnmt_reminder]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[instructor_assgnmt_reminder](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[aid] [varchar](225) NULL,
	[mid] [varchar](225) NULL,
	[midas_id] [varchar](225) NULL,
	[course] [varchar](225) NULL,
	[section] [varchar](225) NULL,
	[due_date] [varchar](225) NULL,
	[day_before] [varchar](225) NULL,
	[week_before] [varchar](225) NULL,
	[on_date] [varchar](225) NULL,
	[setting_type] [varchar](225) NULL,
 CONSTRAINT [PK_instructor_assgnmt_reminder] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[instructor_assgnmt_reminder] ON
INSERT [dbo].[instructor_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date], [setting_type]) VALUES (25, N'1', N'mod1', N'tarun', N'test', N'section1', N'0', N'0', N'0', N'0', N'2')
INSERT [dbo].[instructor_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date], [setting_type]) VALUES (26, N'2', N'mod1', N'tarun', N'test', N'section1', N'0', N'0', N'0', N'0', N'2')
INSERT [dbo].[instructor_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date], [setting_type]) VALUES (27, N'3', N'mod1', N'tarun', N'test', N'section1', N'0', N'0', N'0', N'0', N'2')
INSERT [dbo].[instructor_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date], [setting_type]) VALUES (28, N'4', N'mod1', N'tarun', N'test', N'section1', N'0', N'0', N'0', N'0', N'2')
INSERT [dbo].[instructor_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date], [setting_type]) VALUES (29, N'5', N'mod1', N'tarun', N'test', N'section1', N'0', N'0', N'0', N'0', N'2')
INSERT [dbo].[instructor_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date], [setting_type]) VALUES (30, N'6', N'mod2', N'tarun', N'test', N'section1', N'0', N'0', N'0', N'0', N'2')
INSERT [dbo].[instructor_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date], [setting_type]) VALUES (31, N'7', N'mod2', N'tarun', N'test', N'section1', N'0', N'0', N'0', N'0', N'2')
INSERT [dbo].[instructor_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date], [setting_type]) VALUES (32, N'8', N'mod2', N'tarun', N'test', N'section1', N'0', N'0', N'0', N'0', N'2')
INSERT [dbo].[instructor_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date], [setting_type]) VALUES (33, N'1', N'mod1', NULL, N'', NULL, N'1', N'1', N'0', N'1390156200', N'3')
INSERT [dbo].[instructor_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date], [setting_type]) VALUES (34, N'2', N'mod1', NULL, N'', NULL, N'0', N'0', N'0', N'0', N'3')
INSERT [dbo].[instructor_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date], [setting_type]) VALUES (35, N'3', N'mod1', NULL, N'', NULL, N'0', N'0', N'0', N'0', N'3')
INSERT [dbo].[instructor_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date], [setting_type]) VALUES (36, N'4', N'mod1', NULL, N'', NULL, N'0', N'0', N'0', N'0', N'3')
INSERT [dbo].[instructor_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date], [setting_type]) VALUES (37, N'5', N'mod1', NULL, N'', NULL, N'0', N'0', N'0', N'0', N'3')
INSERT [dbo].[instructor_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date], [setting_type]) VALUES (38, N'6', N'mod2', NULL, N'', NULL, N'0', N'1', N'1', N'1392834600', N'3')
INSERT [dbo].[instructor_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date], [setting_type]) VALUES (39, N'7', N'mod2', NULL, N'', NULL, N'0', N'0', N'0', N'0', N'3')
INSERT [dbo].[instructor_assgnmt_reminder] ([id], [aid], [mid], [midas_id], [course], [section], [due_date], [day_before], [week_before], [on_date], [setting_type]) VALUES (40, N'8', N'mod2', NULL, N'', NULL, N'0', N'0', N'0', N'0', N'3')
SET IDENTITY_INSERT [dbo].[instructor_assgnmt_reminder] OFF
/****** Object:  Table [dbo].[chat_pending_requests]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[chat_pending_requests](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[user_name] [varchar](255) NULL,
	[room_name] [varchar](255) NULL,
	[date] [varchar](255) NULL,
	[status] [int] NOT NULL,
	[course_section] [varchar](255) NULL,
	[is_read] [bit] NOT NULL,
 CONSTRAINT [PK_chat_pending_requests] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[chat_meeting_users]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[chat_meeting_users](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[chat_meeting_name] [varchar](255) NOT NULL,
	[to_user] [varchar](255) NOT NULL,
	[to_course] [varchar](255) NOT NULL,
	[to_section] [varchar](255) NOT NULL,
	[is_attend] [int] NOT NULL,
	[accept_date] [varchar](255) NOT NULL,
	[is_accept] [int] NOT NULL,
	[is_read] [bit] NOT NULL,
 CONSTRAINT [PK_chat_meeting_users] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[chat_meeting_users] ON
INSERT [dbo].[chat_meeting_users] ([id], [chat_meeting_name], [to_user], [to_course], [to_section], [is_attend], [accept_date], [is_accept], [is_read]) VALUES (337, N'roomid_1396955577', N'abhi', N'0', N'0', 1, N'0', 1, 1)
INSERT [dbo].[chat_meeting_users] ([id], [chat_meeting_name], [to_user], [to_course], [to_section], [is_attend], [accept_date], [is_accept], [is_read]) VALUES (338, N'roomid_1396955577', N'bob', N'0', N'0', 0, N'0', 0, 0)
INSERT [dbo].[chat_meeting_users] ([id], [chat_meeting_name], [to_user], [to_course], [to_section], [is_attend], [accept_date], [is_accept], [is_read]) VALUES (339, N'roomid_1396955577', N'charls', N'0', N'0', 0, N'0', 1, 1)
INSERT [dbo].[chat_meeting_users] ([id], [chat_meeting_name], [to_user], [to_course], [to_section], [is_attend], [accept_date], [is_accept], [is_read]) VALUES (340, N'roomid_1396955577', N'chris', N'0', N'0', 0, N'0', 0, 0)
INSERT [dbo].[chat_meeting_users] ([id], [chat_meeting_name], [to_user], [to_course], [to_section], [is_attend], [accept_date], [is_accept], [is_read]) VALUES (341, N'roomid_1396955577', N'priya', N'0', N'0', 0, N'0', 0, 0)
INSERT [dbo].[chat_meeting_users] ([id], [chat_meeting_name], [to_user], [to_course], [to_section], [is_attend], [accept_date], [is_accept], [is_read]) VALUES (342, N'roomid_1396955577', N'richa', N'0', N'0', 0, N'0', 0, 0)
INSERT [dbo].[chat_meeting_users] ([id], [chat_meeting_name], [to_user], [to_course], [to_section], [is_attend], [accept_date], [is_accept], [is_read]) VALUES (343, N'roomid_1396955577', N'sanjay', N'0', N'0', 0, N'0', 2, 1)
INSERT [dbo].[chat_meeting_users] ([id], [chat_meeting_name], [to_user], [to_course], [to_section], [is_attend], [accept_date], [is_accept], [is_read]) VALUES (344, N'roomid_1396955577', N'tarun', N'0', N'0', 1, N'0', 1, 1)
INSERT [dbo].[chat_meeting_users] ([id], [chat_meeting_name], [to_user], [to_course], [to_section], [is_attend], [accept_date], [is_accept], [is_read]) VALUES (345, N'roomid_1396955577', N'yogi', N'0', N'0', 0, N'0', 1, 1)
INSERT [dbo].[chat_meeting_users] ([id], [chat_meeting_name], [to_user], [to_course], [to_section], [is_attend], [accept_date], [is_accept], [is_read]) VALUES (346, N'roomid_1396955577', N'sandy', N'0', N'0', 0, N'1396955577', 1, 1)
INSERT [dbo].[chat_meeting_users] ([id], [chat_meeting_name], [to_user], [to_course], [to_section], [is_attend], [accept_date], [is_accept], [is_read]) VALUES (347, N'roomid_1396975167', N'johnv', N'0', N'0', 0, N'0', 1, 1)
INSERT [dbo].[chat_meeting_users] ([id], [chat_meeting_name], [to_user], [to_course], [to_section], [is_attend], [accept_date], [is_accept], [is_read]) VALUES (348, N'roomid_1396975167', N'asdfasdfa', N'0', N'0', 0, N'1396975167', 1, 1)
INSERT [dbo].[chat_meeting_users] ([id], [chat_meeting_name], [to_user], [to_course], [to_section], [is_attend], [accept_date], [is_accept], [is_read]) VALUES (349, N'roomid_1397296518', N'shalu', N'0', N'0', 1, N'0', 1, 1)
INSERT [dbo].[chat_meeting_users] ([id], [chat_meeting_name], [to_user], [to_course], [to_section], [is_attend], [accept_date], [is_accept], [is_read]) VALUES (350, N'roomid_1397296518', N'amrita', N'0', N'0', 1, N'1397296518', 1, 1)
INSERT [dbo].[chat_meeting_users] ([id], [chat_meeting_name], [to_user], [to_course], [to_section], [is_attend], [accept_date], [is_accept], [is_read]) VALUES (351, N'roomid_1397303273', N'shalu', N'0', N'0', 0, N'0', 0, 0)
INSERT [dbo].[chat_meeting_users] ([id], [chat_meeting_name], [to_user], [to_course], [to_section], [is_attend], [accept_date], [is_accept], [is_read]) VALUES (352, N'roomid_1397303273', N'amrita', N'0', N'0', 1, N'1397303273', 1, 1)
INSERT [dbo].[chat_meeting_users] ([id], [chat_meeting_name], [to_user], [to_course], [to_section], [is_attend], [accept_date], [is_accept], [is_read]) VALUES (353, N'roomid_1397303278', N'abhi', N'0', N'0', 0, N'0', 0, 0)
INSERT [dbo].[chat_meeting_users] ([id], [chat_meeting_name], [to_user], [to_course], [to_section], [is_attend], [accept_date], [is_accept], [is_read]) VALUES (354, N'roomid_1397303278', N'ajax', N'0', N'0', 0, N'0', 0, 0)
INSERT [dbo].[chat_meeting_users] ([id], [chat_meeting_name], [to_user], [to_course], [to_section], [is_attend], [accept_date], [is_accept], [is_read]) VALUES (355, N'roomid_1397303278', N'anuj', N'0', N'0', 0, N'0', 0, 0)
INSERT [dbo].[chat_meeting_users] ([id], [chat_meeting_name], [to_user], [to_course], [to_section], [is_attend], [accept_date], [is_accept], [is_read]) VALUES (356, N'roomid_1397303278', N'asha', N'0', N'0', 0, N'0', 0, 0)
INSERT [dbo].[chat_meeting_users] ([id], [chat_meeting_name], [to_user], [to_course], [to_section], [is_attend], [accept_date], [is_accept], [is_read]) VALUES (357, N'roomid_1397303278', N'jenis', N'0', N'0', 0, N'1397303278', 1, 1)
INSERT [dbo].[chat_meeting_users] ([id], [chat_meeting_name], [to_user], [to_course], [to_section], [is_attend], [accept_date], [is_accept], [is_read]) VALUES (358, N'roomid_1397303422', N'abhi', N'0', N'0', 0, N'0', 0, 0)
INSERT [dbo].[chat_meeting_users] ([id], [chat_meeting_name], [to_user], [to_course], [to_section], [is_attend], [accept_date], [is_accept], [is_read]) VALUES (359, N'roomid_1397303422', N'ajax', N'0', N'0', 0, N'0', 0, 0)
INSERT [dbo].[chat_meeting_users] ([id], [chat_meeting_name], [to_user], [to_course], [to_section], [is_attend], [accept_date], [is_accept], [is_read]) VALUES (360, N'roomid_1397303422', N'anuj', N'0', N'0', 0, N'0', 0, 0)
INSERT [dbo].[chat_meeting_users] ([id], [chat_meeting_name], [to_user], [to_course], [to_section], [is_attend], [accept_date], [is_accept], [is_read]) VALUES (361, N'roomid_1397303422', N'jenis', N'0', N'0', 0, N'1397303422', 1, 1)
INSERT [dbo].[chat_meeting_users] ([id], [chat_meeting_name], [to_user], [to_course], [to_section], [is_attend], [accept_date], [is_accept], [is_read]) VALUES (362, N'roomid_1397543027', N'sanjay', N'0', N'0', 1, N'0', 1, 1)
INSERT [dbo].[chat_meeting_users] ([id], [chat_meeting_name], [to_user], [to_course], [to_section], [is_attend], [accept_date], [is_accept], [is_read]) VALUES (363, N'roomid_1397543027', N'tarun', N'0', N'0', 1, N'1397543027', 1, 1)
SET IDENTITY_INSERT [dbo].[chat_meeting_users] OFF
/****** Object:  Table [dbo].[chat_meeting_info]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[chat_meeting_info](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[chat_meeting_from] [varchar](255) NOT NULL,
	[chat_meeting_title] [varchar](255) NOT NULL,
	[chat_meeting_name] [varchar](255) NOT NULL,
	[chat_meeting_startdate] [varchar](255) NOT NULL,
	[chat_from_course] [varchar](255) NOT NULL,
	[chat_from_section] [varchar](255) NOT NULL,
	[is_active] [int] NOT NULL,
	[chat_meeting_request_date] [varchar](255) NOT NULL,
 CONSTRAINT [PK_chat_meeting_info] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[chat_meeting_info] ON
INSERT [dbo].[chat_meeting_info] ([id], [chat_meeting_from], [chat_meeting_title], [chat_meeting_name], [chat_meeting_startdate], [chat_from_course], [chat_from_section], [is_active], [chat_meeting_request_date]) VALUES (162, N'sandy', N'as', N'roomid_1396955577', N'1396955640', N'2014_test', N'section2', 1, N'1396955577')
INSERT [dbo].[chat_meeting_info] ([id], [chat_meeting_from], [chat_meeting_title], [chat_meeting_name], [chat_meeting_startdate], [chat_from_course], [chat_from_section], [is_active], [chat_meeting_request_date]) VALUES (163, N'asdfasdfa', N'wersdfasdfsdf', N'roomid_1396975167', N'1397039400', N'plecourse', N'section2', 0, N'1396975167')
INSERT [dbo].[chat_meeting_info] ([id], [chat_meeting_from], [chat_meeting_title], [chat_meeting_name], [chat_meeting_startdate], [chat_from_course], [chat_from_section], [is_active], [chat_meeting_request_date]) VALUES (164, N'amrita', N'test meeting', N'roomid_1397296518', N'1397296560', N'2014_test1', N'section1', 1, N'1397296518')
INSERT [dbo].[chat_meeting_info] ([id], [chat_meeting_from], [chat_meeting_title], [chat_meeting_name], [chat_meeting_startdate], [chat_from_course], [chat_from_section], [is_active], [chat_meeting_request_date]) VALUES (165, N'amrita', N'tdasda', N'roomid_1397303273', N'1397303280', N'2014_test1', N'section1', 1, N'1397303273')
INSERT [dbo].[chat_meeting_info] ([id], [chat_meeting_from], [chat_meeting_title], [chat_meeting_name], [chat_meeting_startdate], [chat_from_course], [chat_from_section], [is_active], [chat_meeting_request_date]) VALUES (166, N'jenis', N'tets mee', N'roomid_1397303278', N'1397313960', N'2014_test', N'section1', 0, N'1397303278')
INSERT [dbo].[chat_meeting_info] ([id], [chat_meeting_from], [chat_meeting_title], [chat_meeting_name], [chat_meeting_startdate], [chat_from_course], [chat_from_section], [is_active], [chat_meeting_request_date]) VALUES (167, N'jenis', N'rfrtft', N'roomid_1397303422', N'1397676720', N'2014_test', N'section1', 0, N'1397303422')
INSERT [dbo].[chat_meeting_info] ([id], [chat_meeting_from], [chat_meeting_title], [chat_meeting_name], [chat_meeting_startdate], [chat_from_course], [chat_from_section], [is_active], [chat_meeting_request_date]) VALUES (168, N'tarun', N'b v', N'roomid_1397543027', N'1397543100', N'2014_test', N'section1', 1, N'1397543027')
SET IDENTITY_INSERT [dbo].[chat_meeting_info] OFF
/****** Object:  Table [dbo].[chat_invited_users]    Script Date: 04/15/2014 14:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[chat_invited_users](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[chat_from] [varchar](225) NULL,
	[chat_to] [varchar](225) NULL,
	[room_name] [varchar](255) NULL,
	[status] [int] NOT NULL,
	[from_course_section] [varchar](255) NULL,
	[to_course_section] [varchar](255) NULL,
	[request_data] [varchar](255) NULL,
	[pis_read] [bit] NOT NULL,
	[dis_read] [bit] NOT NULL,
 CONSTRAINT [PK_chat_invited_users] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[chat_invited_users] ON
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1794, N'tarun', N'sanjay', N'roomid_1396953371', 1, N'2014_test-section1', N'2014_test-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1795, N'tarun', N'bob', N'roomid_1396954434', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1796, N'tarun', N'bob', N'roomid_1396954440', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1797, N'sandy', N'yogi', N'roomid_1396955168', 0, N'2014_test-section2', N'2014_test-section1', NULL, 1, 1)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1798, N'sandy', N'yogi', N'roomid_1396955296', 0, N'2014_test-section2', N'2014_test-section1', NULL, 1, 1)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1799, N'sandy', N'yogi', N'roomid_1396955299', 1, N'2014_test-section2', N'2014_test-section1', NULL, 1, 1)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1800, N'sandy', N'yogi', N'roomid_1396955342', 0, N'2014_test-section2', N'2014_test-section1', NULL, 1, 1)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1801, N'sandy', N'-1', N'roomid_1396955357', 2, N'2014_test-section2', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1802, N'sandy', N'charls', N'roomid_1396955357', 2, N'2014_test-section2', N'2014_test-section1', NULL, 1, 1)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1803, N'sandy', N'abhi', N'roomid_1396955357', 2, N'2014_test-section2', N'2014_test-section1', NULL, 1, 1)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1804, N'sandy', N'-1', N'roomid_1396955357', 2, N'2014_test-section2', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1805, N'sandy', N'abhi', N'roomid_1396955830', 0, N'2014_test-section2', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1806, N'-1', N'abhi', N'roomid_1396955862', 0, N'2014_test-section2', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1807, N'-1', N'yogi', N'roomid_1396955888', 0, N'2014_test-section2', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1808, N'-1', N'charls', N'roomid_1396955902', 0, N'2014_test-section2', N'2014_test-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1809, N'tarun', N'abhi', N'roomid_1396955914', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1810, N'-1', N'abhi', N'roomid_1396955929', 0, N'2014_test-section2', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1811, N'abhi', N'charls', N'roomid_1396956028', 2, N'2014_test-section1', N'2014_test-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1812, N'tarun', N'charls', N'roomid_1396958955', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1813, N'dan', N'dexter', N'roomid_1396973521', 2, N'plecourse-section1', N'plecourse-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1814, N'uo8ybu6hfe', N'-1', N'roomid_1396974246', 2, N'plecourse-section1', N'plecourse-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1815, N'hxgxf3ld9p', N'-1', N'roomid_1396974250', 2, N'plecourse-section1', N'plecourse-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1816, N'np17qifhgp', N'xi9spmowa0', N'roomid_1396974396', 2, N'plecourse-section1', N'plecourse-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1817, N'ztdsnl6vgl', N'macuser1', N'roomid_1396974398', 2, N'plecourse-section1', N'plecourse-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1818, N'-1', N'np17qifhgp', N'roomid_1396974477', 2, N'plecourse-section1', N'plecourse-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1819, N'c66gedfyux', N'jxkmexva7w', N'roomid_1396974598', 2, N'plecourse-section1', N'plecourse-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1820, N'skk1lw1kw1', N'lastpc', N'roomid_1396974860', 2, N'plecourse-section1', N'plecourse-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1821, N'asdfasdfa', N'johnv', N'roomid_1396975221', 2, N'plecourse-section2', N'plecourse-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1822, N'dexter', N'morgan', N'roomid_1396975483', 2, N'plecourse-section1', N'plecourse-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1823, N'johnv', N'morgan', N'roomid_1396975496', 2, N'plecourse-section1', N'plecourse-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1824, N'-1', N'dexter', N'roomid_1396975486', 2, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1825, N'-1', N'morgan', N'roomid_1396975559', 2, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1826, N'johnv', N'dexter', N'roomid_1396975554', 2, N'plecourse-section1', N'plecourse-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1827, N'-1', N'johnv', N'roomid_1396975584', 2, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1828, N'-1', N'dexter', N'roomid_1396975626', 2, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1829, N'jompkgnhz5', N'jxkmexva7w', N'roomid_1396975876', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1830, N'jompkgnhz5', N'vgglne2dsg', N'roomid_1396975877', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1831, N'jompkgnhz5', N'j2gp6ej6d7', N'roomid_1396975878', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1832, N'jompkgnhz5', N'jkkrudrlxx', N'roomid_1396975878', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1833, N'zdjongtrnf', N'c7bc3nerwx', N'roomid_1396975882', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1834, N'zdjongtrnf', N'dan', N'roomid_1396975883', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1835, N'zdjongtrnf', N'9ymtyjsptd', N'roomid_1396975884', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1836, N'9ymtyjsptd', N'c7bc3nerwx', N'roomid_1396975885', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1837, N'9ymtyjsptd', N'zdjongtrnf', N'roomid_1396975886', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1838, N'9ymtyjsptd', N'dexter', N'roomid_1396975886', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1839, N'9ymtyjsptd', N'awxmb8jeit', N'roomid_1396975887', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1840, N'c7bc3nerwx', N'awxmb8jeit', N'roomid_1396975888', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1841, N'c7bc3nerwx', N'dexter', N'roomid_1396975888', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1842, N'hxgxf3ld9p', N'uo8ybu6hfe', N'roomid_1396975897', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1843, N'hxgxf3ld9p', N'vgglne2dsg', N'roomid_1396975897', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1844, N'hxgxf3ld9p', N'zdjongtrnf', N'roomid_1396975898', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1845, N'asdfasdfa', N'jompkgnhz5', N'roomid_1396975887', 0, N'plecourse-section2', N'plecourse-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1846, N'uo8ybu6hfe', N'jompkgnhz5', N'roomid_1396975899', 0, N'plecourse-section1', N'plecourse-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1847, N'uo8ybu6hfe', N'vgglne2dsg', N'roomid_1396975899', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1848, N'uo8ybu6hfe', N'dexter', N'roomid_1396975900', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1849, N'i7ruer3hcn', N'jompkgnhz5', N'roomid_1396975906', 0, N'plecourse-section1', N'plecourse-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1850, N'i7ruer3hcn', N'vgglne2dsg', N'roomid_1396975908', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1851, N'rg7hejsba3', N'9ymtyjsptd', N'roomid_1396975926', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1852, N'ztdsnl6vgl', N'dexter', N'roomid_1396975928', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1853, N'ztdsnl6vgl', N'macuser1', N'roomid_1396975929', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1854, N'ztdsnl6vgl', N'uo8ybu6hfe', N'roomid_1396975930', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1855, N'macuser1', N'jompkgnhz5', N'roomid_1396975935', 0, N'plecourse-section1', N'plecourse-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1856, N'macuser1', N'jxkmexva7w', N'roomid_1396975935', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1857, N'macuser1', N'i7ruer3hcn', N'roomid_1396975936', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1858, N'loky31fzw3', N'jompkgnhz5', N'roomid_1396975942', 0, N'plecourse-section1', N'plecourse-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1859, N'loky31fzw3', N'awxmb8jeit', N'roomid_1396975942', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1860, N'loky31fzw3', N'ovrzt7ush0', N'roomid_1396975943', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1861, N'muadhsl8j9', N'jompkgnhz5', N'roomid_1396975944', 0, N'plecourse-section1', N'plecourse-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1862, N'muadhsl8j9', N'c7bc3nerwx', N'roomid_1396975945', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1863, N'muadhsl8j9', N'np17qifhgp', N'roomid_1396975945', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1864, N'ebjv70iwln', N'jompkgnhz5', N'roomid_1396975947', 0, N'plecourse-section1', N'plecourse-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1865, N'ebjv70iwln', N'dexter', N'roomid_1396975947', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1866, N'ebjv70iwln', N'macuser1', N'roomid_1396975948', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1867, N'c66gedfyux', N'zdjongtrnf', N'roomid_1396975953', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1868, N'wpkbwvaduh', N'jompkgnhz5', N'roomid_1396975959', 0, N'plecourse-section1', N'plecourse-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1869, N'wpkbwvaduh', N'jxkmexva7w', N'roomid_1396975959', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1870, N'wpkbwvaduh', N'muadhsl8j9', N'roomid_1396975960', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1871, N'a4htdsz3k0', N'loky31fzw3', N'roomid_1396975961', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1872, N'a4htdsz3k0', N'c66gedfyux', N'roomid_1396975962', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1873, N'a4htdsz3k0', N'hxgxf3ld9p', N'roomid_1396975962', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1874, N'swqqiej5dp', N'jompkgnhz5', N'roomid_1396975964', 0, N'plecourse-section1', N'plecourse-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1875, N'swqqiej5dp', N'muadhsl8j9', N'roomid_1396975964', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1876, N'swqqiej5dp', N'ztdsnl6vgl', N'roomid_1396975965', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1877, N'oz6xswkuui', N'loky31fzw3', N'roomid_1396976015', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1878, N'oz6xswkuui', N'9ymtyjsptd', N'roomid_1396976016', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1879, N'oz6xswkuui', N'9ymtyjsptd', N'roomid_1396976016', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1880, N'ub9diu7cbe', N'jxkmexva7w', N'roomid_1396976023', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1881, N'ub9diu7cbe', N'vgglne2dsg', N'roomid_1396976024', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1882, N'ub9diu7cbe', N'ztdsnl6vgl', N'roomid_1396976024', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1883, N'drsczj3iz4', N'oz6xswkuui', N'roomid_1396975988', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1884, N'drsczj3iz4', N'j2gp6ej6d7', N'roomid_1396975988', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1885, N'drsczj3iz4', N'a4htdsz3k0', N'roomid_1396975989', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1886, N'pl5a7evtmw', N'uo8ybu6hfe', N'roomid_1396975991', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1887, N'pl5a7evtmw', N'oz6xswkuui', N'roomid_1396975992', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1888, N'pl5a7evtmw', N'j2gp6ej6d7', N'roomid_1396975992', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1889, N'dr4pqc0k3a', N'jompkgnhz5', N'roomid_1396976023', 0, N'plecourse-section1', N'plecourse-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1890, N'dr4pqc0k3a', N'jxkmexva7w', N'roomid_1396976023', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1891, N'skk1lw1kw1', N'pl5a7evtmw', N'roomid_1396976079', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1892, N'skk1lw1kw1', N'64drrdo8mb', N'roomid_1396976079', 2, N'plecourse-section1', N'plecourse-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1893, N'skk1lw1kw1', N'lastpc', N'roomid_1396976079', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
GO
print 'Processed 100 total records'
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1894, N'skk1lw1kw1', N'lastpc', N'roomid_1396976079', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1895, N'fiynbwodea', N'jxkmexva7w', N'roomid_1396976047', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1896, N'fiynbwodea', N'i7ruer3hcn', N'roomid_1396976047', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1897, N'fiynbwodea', N'muadhsl8j9', N'roomid_1396976048', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1898, N'fiynbwodea', N'ekbstj0yre', N'roomid_1396976049', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1899, N'jkkrudrlxx', N'vgglne2dsg', N'roomid_1396976114', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1900, N'jkkrudrlxx', N'muadhsl8j9', N'roomid_1396976114', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1901, N'jkkrudrlxx', N'muadhsl8j9', N'roomid_1396976115', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1902, N'jkkrudrlxx', N'i7ruer3hcn', N'roomid_1396976115', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1903, N'gh2uosldxo', N'jompkgnhz5', N'roomid_1396976094', 0, N'plecourse-section1', N'plecourse-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1904, N'gh2uosldxo', N'jxkmexva7w', N'roomid_1396976096', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1905, N'gh2uosldxo', N'ub9diu7cbe', N'roomid_1396976097', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1906, N'gh2uosldxo', N'q9y3whnmc3', N'roomid_1396976097', 2, N'plecourse-section1', N'plecourse-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1907, N'y8agbzayxg', N'jompkgnhz5', N'roomid_1396976203', 0, N'plecourse-section1', N'plecourse-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1908, N'anita', N'jompkgnhz5', N'roomid_1396976762', 0, N'plecourse-section1', N'plecourse-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1909, N'-1', N'sanjay', N'roomid_1397275669', 0, N'2014_test-section1', N'2014_test-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1910, N'-1', N'sanjay', N'roomid_1397275681', 0, N'2014_test-section1', N'2014_test-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1911, N'-1', N'sanjay', N'roomid_1397275773', 0, N'2014_test-section1', N'2014_test-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1912, N'-1', N'sanjay', N'roomid_1397275777', 0, N'2014_test-section1', N'2014_test-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1913, N'-1', N'sanjay', N'roomid_1397275780', 0, N'2014_test-section1', N'2014_test-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1914, N'-1', N'sanjay', N'roomid_1397275784', 0, N'2014_test-section1', N'2014_test-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1924, N'-1', N'sanjay', N'roomid_1397275920', 0, N'2014_test-section1', N'2014_test-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1935, N'-1', N'tarun', N'roomid_1397276912', 0, N'2014_test-section1', N'2014_test-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1948, N'sanjay', N'tarun', N'roomid_1397277624', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1949, N'sanjay', N'tarun', N'roomid_1397277626', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1950, N'sanjay', N'tarun', N'roomid_1397277627', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1951, N'sanjay', N'tarun', N'roomid_1397277630', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1952, N'sanjay', N'tarun', N'roomid_1397277633', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1953, N'-1', N'tarun', N'roomid_1397277752', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1954, N'-1', N'tarun', N'roomid_1397277752', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1955, N'sanjay', N'tarun', N'roomid_1397277754', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1956, N'sanjay', N'tarun', N'roomid_1397277756', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1957, N'sanjay', N'tarun', N'roomid_1397277773', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1958, N'sanjay', N'tarun', N'roomid_1397277802', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1959, N'sanjay', N'tarun', N'roomid_1397277808', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1960, N'sanjay', N'tarun', N'roomid_1397277809', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1961, N'sanjay', N'tarun', N'roomid_1397277811', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1962, N'sanjay', N'tarun', N'roomid_1397278079', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1963, N'sanjay', N'tarun', N'roomid_1397278082', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1964, N'sanjay', N'tarun', N'roomid_1397278086', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1965, N'sanjay', N'tarun', N'roomid_1397278089', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1966, N'sanjay', N'tarun', N'roomid_1397278364', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1967, N'sanjay', N'tarun', N'roomid_1397278365', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1968, N'sanjay', N'tarun', N'roomid_1397278367', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1969, N'sanjay', N'tarun', N'roomid_1397278369', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1973, N'sanjay', N'tarun', N'roomid_1397278886', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1976, N'sanjay', N'tarun', N'roomid_1397279008', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1980, N'sanjay', N'tarun', N'roomid_1397279445', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1981, N'sanjay', N'tarun', N'roomid_1397279447', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1982, N'sanjay', N'tarun', N'roomid_1397286891', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1985, N'tarun', N'sanjay', N'roomid_1397294656', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1986, N'sanjay', N'tarun', N'roomid_1397295995', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1987, N'-1', N'amrita', N'roomid_1397296054', 2, N'2014_test1-section1', N'2014_test1-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1988, N'amrita', N'-1', N'roomid_1397296058', 2, N'2014_test1-section1', N'2014_test1-section1', NULL, 1, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1989, N'ruby', N'amrita', N'roomid_1397296718', 0, N'2014_test1-section2', N'2014_test1-section1', NULL, 0, 0)
INSERT [dbo].[chat_invited_users] ([id], [chat_from], [chat_to], [room_name], [status], [from_course_section], [to_course_section], [request_data], [pis_read], [dis_read]) VALUES (1990, N'sanjay', N'tarun', N'roomid_1397542903', 0, N'2014_test-section1', N'2014_test-section1', NULL, 0, 0)
SET IDENTITY_INSERT [dbo].[chat_invited_users] OFF
/****** Object:  Default [DF_student_assgnmt_reminder_due_date]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[student_assgnmt_reminder] ADD  CONSTRAINT [DF_student_assgnmt_reminder_due_date]  DEFAULT ((0)) FOR [due_date]
GO
/****** Object:  Default [DF_student_assgnmt_reminder_day_before]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[student_assgnmt_reminder] ADD  CONSTRAINT [DF_student_assgnmt_reminder_day_before]  DEFAULT ((0)) FOR [day_before]
GO
/****** Object:  Default [DF_student_assgnmt_reminder_week_before]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[student_assgnmt_reminder] ADD  CONSTRAINT [DF_student_assgnmt_reminder_week_before]  DEFAULT ((0)) FOR [week_before]
GO
/****** Object:  Default [DF_student_assgnmt_reminder_on_date]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[student_assgnmt_reminder] ADD  CONSTRAINT [DF_student_assgnmt_reminder_on_date]  DEFAULT ((0)) FOR [on_date]
GO
/****** Object:  Default [DF_ple_user_reminder_setting_is_email]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_user_reminder_setting] ADD  CONSTRAINT [DF_ple_user_reminder_setting_is_email]  DEFAULT ((0)) FOR [is_email]
GO
/****** Object:  Default [DF_ple_user_reminder_setting_is_feed_reader]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_user_reminder_setting] ADD  CONSTRAINT [DF_ple_user_reminder_setting_is_feed_reader]  DEFAULT ((0)) FOR [is_feed_reader]
GO
/****** Object:  Default [DF_ple_user_reminder_setting_is_text_msg]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_user_reminder_setting] ADD  CONSTRAINT [DF_ple_user_reminder_setting_is_text_msg]  DEFAULT ((0)) FOR [is_text_msg]
GO
/****** Object:  Default [DF_ple_user_reminder_setting_is_facebook]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_user_reminder_setting] ADD  CONSTRAINT [DF_ple_user_reminder_setting_is_facebook]  DEFAULT ((0)) FOR [is_facebook]
GO
/****** Object:  Default [DF_ple_user_reminder_setting_is_twitter]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_user_reminder_setting] ADD  CONSTRAINT [DF_ple_user_reminder_setting_is_twitter]  DEFAULT ((0)) FOR [is_twitter]
GO
/****** Object:  Default [DF_ple_user_map_twitter_twitterId]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_user_map_twitter] ADD  CONSTRAINT [DF_ple_user_map_twitter_twitterId]  DEFAULT ((0)) FOR [twitterId]
GO
/****** Object:  Default [DF_ple_reply_access_is_read]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_reply_access] ADD  CONSTRAINT [DF_ple_reply_access_is_read]  DEFAULT ((0)) FOR [is_read]
GO
/****** Object:  Default [DF_ple_recent_post_setting_count]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_recent_post_setting] ADD  CONSTRAINT [DF_ple_recent_post_setting_count]  DEFAULT ((4)) FOR [count]
GO
/****** Object:  Default [DF_ple_recent_post_setting_view_name]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_recent_post_setting] ADD  CONSTRAINT [DF_ple_recent_post_setting_view_name]  DEFAULT ('activeposts') FOR [view_name]
GO
/****** Object:  Default [DF_ple_questions_thread_is_reply]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_questions_thread] ADD  CONSTRAINT [DF_ple_questions_thread_is_reply]  DEFAULT ((0)) FOR [is_reply]
GO
/****** Object:  Default [DF_ple_questions_thread_is_draft]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_questions_thread] ADD  CONSTRAINT [DF_ple_questions_thread_is_draft]  DEFAULT ((0)) FOR [is_draft]
GO
/****** Object:  Default [DF_ple_questions_thread_ancestor_id]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_questions_thread] ADD  CONSTRAINT [DF_ple_questions_thread_ancestor_id]  DEFAULT ((0)) FOR [ancestor_id]
GO
/****** Object:  Default [DF_ple_questions_access_is_read]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_questions_access] ADD  CONSTRAINT [DF_ple_questions_access_is_read]  DEFAULT ((0)) FOR [is_read]
GO
/****** Object:  Default [DF_ple_questions_access_is_pinned]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_questions_access] ADD  CONSTRAINT [DF_ple_questions_access_is_pinned]  DEFAULT ((0)) FOR [is_pin]
GO
/****** Object:  Default [DF_ple_questions_access_is_flag]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_questions_access] ADD  CONSTRAINT [DF_ple_questions_access_is_flag]  DEFAULT ((0)) FOR [is_flag]
GO
/****** Object:  Default [DF_ple_questions_access_parent_id]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_questions_access] ADD  CONSTRAINT [DF_ple_questions_access_parent_id]  DEFAULT ((0)) FOR [parent_id]
GO
/****** Object:  Default [DF_ple_questions_access_post_type]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_questions_access] ADD  CONSTRAINT [DF_ple_questions_access_post_type]  DEFAULT ('question') FOR [post_type]
GO
/****** Object:  Default [DF_ple_questions_is_reply]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_questions] ADD  CONSTRAINT [DF_ple_questions_is_reply]  DEFAULT ((0)) FOR [is_reply]
GO
/****** Object:  Default [DF_ple_questions_is_draft]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_questions] ADD  CONSTRAINT [DF_ple_questions_is_draft]  DEFAULT ((0)) FOR [is_draft]
GO
/****** Object:  Default [DF_ple_forum_subscription_setting_setting_value]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_forum_subscription_setting] ADD  CONSTRAINT [DF_ple_forum_subscription_setting_setting_value]  DEFAULT ((0)) FOR [setting_value]
GO
/****** Object:  Default [DF_ple_forum_subscription_setting_subscription_type]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_forum_subscription_setting] ADD  CONSTRAINT [DF_ple_forum_subscription_setting_subscription_type]  DEFAULT ((0)) FOR [subscription_type]
GO
/****** Object:  Default [DF_ple_contentpage_topic_id]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_contentpage_topic] ADD  CONSTRAINT [DF_ple_contentpage_topic_id]  DEFAULT ((1)) FOR [id]
GO
/****** Object:  Default [DF_ple_contentpage_setting_start_date]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_contentpage_setting] ADD  CONSTRAINT [DF_ple_contentpage_setting_start_date]  DEFAULT ((0)) FOR [start_date]
GO
/****** Object:  Default [DF_ple_contentpage_setting_end_date]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_contentpage_setting] ADD  CONSTRAINT [DF_ple_contentpage_setting_end_date]  DEFAULT ((2020426106)) FOR [end_date]
GO
/****** Object:  Default [DF_ple_contentpage_setting_rstart_date]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_contentpage_setting] ADD  CONSTRAINT [DF_ple_contentpage_setting_rstart_date]  DEFAULT ((0)) FOR [rstart_date]
GO
/****** Object:  Default [DF_ple_contentpage_setting_rend_date]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_contentpage_setting] ADD  CONSTRAINT [DF_ple_contentpage_setting_rend_date]  DEFAULT ((2020426106)) FOR [rend_date]
GO
/****** Object:  Default [DF_ple_contentpage_ro_setting_start_date]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_contentpage_ro_setting] ADD  CONSTRAINT [DF_ple_contentpage_ro_setting_start_date]  DEFAULT ((0)) FOR [start_date]
GO
/****** Object:  Default [DF_ple_contentpage_ro_setting_end_date]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_contentpage_ro_setting] ADD  CONSTRAINT [DF_ple_contentpage_ro_setting_end_date]  DEFAULT ((0)) FOR [end_date]
GO
/****** Object:  Default [DF_ple_assignment_reminder_due_date]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_assignment_reminder] ADD  CONSTRAINT [DF_ple_assignment_reminder_due_date]  DEFAULT ((0)) FOR [due_date]
GO
/****** Object:  Default [DF_ple_assignment_reminder_remind_week_before]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_assignment_reminder] ADD  CONSTRAINT [DF_ple_assignment_reminder_remind_week_before]  DEFAULT ((0)) FOR [remind_week_before]
GO
/****** Object:  Default [DF_ple_assignment_reminder_remind_day_before]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_assignment_reminder] ADD  CONSTRAINT [DF_ple_assignment_reminder_remind_day_before]  DEFAULT ((0)) FOR [remind_day_before]
GO
/****** Object:  Default [DF_ple_assignment_reminder_remind_day_of]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[ple_assignment_reminder] ADD  CONSTRAINT [DF_ple_assignment_reminder_remind_day_of]  DEFAULT ((0)) FOR [remind_day_of]
GO
/****** Object:  Default [DF_instructor_assgnmt_reminder_due_date]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[instructor_assgnmt_reminder] ADD  CONSTRAINT [DF_instructor_assgnmt_reminder_due_date]  DEFAULT ((0)) FOR [due_date]
GO
/****** Object:  Default [DF_instructor_assgnmt_reminder_day_before]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[instructor_assgnmt_reminder] ADD  CONSTRAINT [DF_instructor_assgnmt_reminder_day_before]  DEFAULT ((0)) FOR [day_before]
GO
/****** Object:  Default [DF_instructor_assgnmt_reminder_week_before]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[instructor_assgnmt_reminder] ADD  CONSTRAINT [DF_instructor_assgnmt_reminder_week_before]  DEFAULT ((0)) FOR [week_before]
GO
/****** Object:  Default [DF_instructor_assgnmt_reminder_on_date]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[instructor_assgnmt_reminder] ADD  CONSTRAINT [DF_instructor_assgnmt_reminder_on_date]  DEFAULT ((0)) FOR [on_date]
GO
/****** Object:  Default [DF_chat_pending_requests_status]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[chat_pending_requests] ADD  CONSTRAINT [DF_chat_pending_requests_status]  DEFAULT ((0)) FOR [status]
GO
/****** Object:  Default [DF_chat_pending_requests_is_read]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[chat_pending_requests] ADD  CONSTRAINT [DF_chat_pending_requests_is_read]  DEFAULT ((0)) FOR [is_read]
GO
/****** Object:  Default [DF_chat_meeting_users_is_read]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[chat_meeting_users] ADD  CONSTRAINT [DF_chat_meeting_users_is_read]  DEFAULT ((0)) FOR [is_read]
GO
/****** Object:  Default [DF_chat_invited_users_status]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[chat_invited_users] ADD  CONSTRAINT [DF_chat_invited_users_status]  DEFAULT ((0)) FOR [status]
GO
/****** Object:  Default [DF_chat_invited_users_pis_read]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[chat_invited_users] ADD  CONSTRAINT [DF_chat_invited_users_pis_read]  DEFAULT ((0)) FOR [pis_read]
GO
/****** Object:  Default [DF_chat_invited_users_dis_read]    Script Date: 04/15/2014 14:15:40 ******/
ALTER TABLE [dbo].[chat_invited_users] ADD  CONSTRAINT [DF_chat_invited_users_dis_read]  DEFAULT ((0)) FOR [dis_read]
GO
