-- User related tables located below --

CREATE TABLE Users (
	UserID int AUTO_INCREMENT NOT NULL,
	Username char(63) NOT NULL,
	Pasword char(255) NOT NULL,
	ProfilePic char(255),
	Email char(127),
	Bio text,
	SchoolID int,
	
	PRIMARY KEY (UserID),

	FOREIGN KEY (SchoolID)
	REFERENCES Users(SchoolID)
);

CREATE TABLE Admins (
	UserID int NOT NULL,
	RSO_ID int NOT NULL,
	
	PRIMARY KEY (UserID, RSO_ID),
	
	FOREIGN KEY (UserID)
		REFERENCES Users(UserID),
	
	FOREIGN KEY (RSO_ID)
		REFERENCES RSO(RSO_ID)
		ON DELETE CASCADE
);

CREATE TABLE Members(

	UserID int NOT NULL,
	RSO_ID int NOT NULL,
	
	PRIMARY KEY (UserID, RSO_ID),
	
	FOREIGN KEY (UserID)
		REFERENCES Users(UserID)
		ON DELETE CASCADE,
	
	FOREIGN KEY (RSO_ID)
		REFERENCES RSO(RSO_ID)
		ON DELETE CASCADE
);

CREATE TABLE Super_Admins (
	UserID int NOT NULL,
	SchoolID int NOT NULL,
	
	PRIMARY KEY (SchoolID, UserID),
	
	FOREIGN KEY (UserID)
		REFERENCES Users(UserID),
		
	FOREIGN KEY (SchoolID)
		REFERENCES School(SchoolID)
		ON DELETE CASCADE
);

CREATE TABLE Students(
	UserID int NOT NULL,
	SchoolID int NOT NULL,
	
	PRIMARY KEY (SchoolID, UserID),
	
	FOREIGN KEY (UserID)
		REFERENCES Users(UserID)
		ON DELETE CASCADE,
		
	FOREIGN KEY (SchoolID)
		REFERENCES School(SchoolID)
		ON DELETE CASCADE
);

CREATE TABLE Non_RSO_Event(
	UserID int NOT NULL,
	SuperAdminID int,
	EventID int NOT NULL,
	
	PRIMARY KEY (UserID, EventID),
	
	FOREIGN KEY (UserID)
		REFERENCES Users(UserID)
		ON DELETE CASCADE,
		
	FOREIGN KEY (EventID)
		REFERENCES Events(EventID)
		ON DELETE CASCADE,
	
	FOREIGN KEY (SuperAdminID)
		REFERENCES Super_Admins(UserID)
		ON DELETE CASCADE
);
-- Recognised School Organizations tables located below

CREATE TABLE RSO (
	RSO_ID int AUTO_INCREMENT NOT NULL,
	RSO_Name char(255) NOT NULL,
	RSO_CreationDate DATE,
	NumofMembers int NOT NULL,
	RSO_Desc text,
	RSO_ProfPic char(255) NOT NULL,
	
	PRIMARY KEY (RSO_ID)
)
;
CREATE TABLE RSO_Pics (
	PicID int AUTO_INCREMENT NOT NULL,
	Dir char(255) NOT NULL,
	RSO_ID int NOT NULL,
	
	PRIMARY KEY (PicID, RSO_ID),
	
	FOREIGN KEY (RSO_ID)
		REFERENCES RSO(RSO_ID)
);

CREATE TABLE RSO_Ran_Event (
	HostID int NOT NULL,
	EventID int NOT NULL,
	
	PRIMARY KEY (HostID, EventID),
	
	FOREIGN KEY (HostID)
		REFERENCES Member(UserID),
	
	FOREIGN KEY (EventID)
		REFERENCES Events(EventID)
);

-- School related tables below --

CREATE TABLE School (
	SchoolID int AUTO_INCREMENT NOT NULL,
	SchoolName char(255) NOT NULL,
	SchoolPic char(255) NOT NULL,
	SchoolDesc text,
	NumOfStudents int NOT NULL,
	NumOfRSOSs int NOT NULL,
	School_Lat real,
	School_long real,
	
	PRIMARY KEY (SchoolID)
);

CREATE TABLE SchoolPictures (
	PicID int AUTO_INCREMENT NOT NULL,
	Dir char(255) NOT NULL,
	SchoolID int NOT NULL,
	
	PRIMARY KEY (PicID, SchoolID),
	
	FOREIGN KEY (SchoolID)
		REFERENCES School(SchoolID)
		ON DELETE CASCADE
);

-- Event related tables below --

CREATE TABLE Events (
	EventID int AUTO_INCREMENT NOT NULL,
	EventName char(127) NOT NULL,
	EventPic char(255) NOT NULL,
	MainLocationID int NOT NULL,
	StartDate DATE NOT NULL,
	StartTime TIME NOT NULL,
	EndTime TIME NOT NULL,
	EndDate DATE,
	EventDesc text,
	InviteType int NOT NULL,
	Host_RSO_ID int,
	
	PRIMARY KEY (EventID),
	
	FOREIGN KEY (MainLocationID)
		REFERENCES Locations(locationID),
	
	FOREIGN KEY (Host_RSO_ID)
		REFERENCES Users(UserID)
		ON DELETE SET NULL -- need a check here to see
);

CREATE TABLE EventType(
	EventID int NOT NULL,
	TypeID int NOT NULL,
	
	PRIMARY KEY (EventID, TypeID),
	
	FOREIGN KEY (EventID)
		REFERENCES Events(EventID)
		ON DELETE CASCADE,
		
	FOREIGN KEY (TypeID)
		REFERENCES Types(TypeID)
		ON DELETE CASCADE
);

CREATE TABLE Types(
	TypeID int AUTO_INCREMENT NOT NULL,
	TypeName char(31),
	
	PRIMARY KEY (TypeID)
);

CREATE TABLE EventPics (
	PicID int AUTO_INCREMENT NOT NULL,
	Dir char(255) NOT NULL,
	EventID int NOT NULL,
	
	PRIMARY KEY (PicID, EventID),
	
	FOREIGN KEY (EventID)
		REFERENCES Events(EventID)
		ON DELETE CASCADE
);

CREATE TABLE Locations(
	locID int AUTO_INCREMENT NOT NULL,
	locName char(63) NOT NULL UNIQUE,
	longitude real NOT NULL,
	latitude real NOT NULL,
	floorNum int,
	Room int,
	
	PRIMARY KEY (locID)
);

CREATE TABLE Commented (
	UserID int NOT NULL,
	EventID int NOT NULL,
	Rating real NOT NULL,
	Text text,
	TimePrint TIME,
	DayOfPost DATE,
	
	PRIMARY KEY (UserID, EventID),
	
	FOREIGN KEY  (UserID)
		REFERENCES Users(userID)
		ON DELETE CASCADE,
		
	FOREIGN KEY (EventID)
		REFERENCES Events(EventID)
		ON DELETE CASCADE
)