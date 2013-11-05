PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE "Author" (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    "name" TEXT NOT NULL
);
INSERT INTO "Author" VALUES(1,'Jos');
INSERT INTO "Author" VALUES(2,'Piet');
CREATE TABLE "BlogPost" (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    "authorId" INTEGER NOT NULL,
    "content" TEXT NOT NULL,
	FOREIGN KEY ("authorId") REFERENCES "Author"("id")
);
INSERT INTO "BlogPost" VALUES(1,1,'Goe bezig');
INSERT INTO "BlogPost" VALUES(2,2,'Iel goe bezig');
CREATE TABLE "Comment" (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    "authorId" INTEGER NOT NULL,
    "blogPostId" INTEGER NOT NULL,
    "content" TEXT NOT NULL,
	FOREIGN KEY ("authorId") REFERENCES "Author"("id"),
	FOREIGN KEY ("blogPostId") REFERENCES "BlogPost"("id")
);
INSERT INTO "Comment" VALUES(1,2,1,'Dank je');
INSERT INTO "Comment" VALUES(2,1,1,'Graag gedaan');
INSERT INTO "Comment" VALUES(3,1,2,'Heel erg bedankt');
INSERT INTO "Comment" VALUES(4,2,2,'Heel erg graag gedaan');
DELETE FROM sqlite_sequence;
INSERT INTO "sqlite_sequence" VALUES('Author',2);
INSERT INTO "sqlite_sequence" VALUES('BlogPost',2);
INSERT INTO "sqlite_sequence" VALUES('Comment',4);
COMMIT;
