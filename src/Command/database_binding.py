import sqlalchemy
from sqlalchemy.ext.declarative import declarative_base
from sqlalchemy import Column, Integer, String, Date, Time, ForeignKey
from sqlalchemy.orm import relationship, sessionmaker

Base = declarative_base()

class Faculties(Base):
    __tablename__ = 'faculties'
    id = Column(Integer, primary_key = True)
    name = Column(String(50))

    def __repr__(self):
       return "<Faculty(name = {})".format(self.name)

class Cycles(Base):
    __tablename__ = 'cycles'
    id = Column(Integer, primary_key = True)
    name = Column(String(50))
    faculty_id = Column(Integer, ForeignKey('faculties.id'))

    def __repr__(self):
       return "<Cycle(name = {})".format(self.name)

class Years(Base):
    __tablename__ = 'years'
    id = Column(Integer, primary_key = True)
    name = Column(String(50))
    cycle_id = Column(Integer, ForeignKey('cycles.id'))

    def __repr__(self):
       return "<Year(name = {})".format(self.name)

class Groups(Base):
    __tablename__ = 'groups'
    id = Column(Integer, primary_key = True)
    name = Column(String(50))
    year_id = Column(Integer, ForeignKey('years.id'))

    def __repr__(self):
       return "<Group(name = {})".format(self.name)

class Schedule(Base):
    __tablename__ = 'schedule'
    id = Column(Integer, primary_key = True)
    group_id = Column(Integer, ForeignKey('groups.id'))
    group = relationship("Groups")
    classes_date = Column(Date)
    classes_start_time = Column(Time)
    classes_end_time = Column(Time)
    classes_Name = Column(String(100))
    lecturer_name = Column(String(100))
    place = Column(String(100))

    def __repr__(self):
       return "<Schedule..." # TODO

class dbConnection():
    def __init__(self):
        self._dbUser = "schedulepk"
        self._passWrd = "schedulepk"
        self._dbName = "schedule_pk"
        self._url = "pma.podzialpk.pl"
        self._connString = "mysql://{}:{}@{}/{}?charset=utf8".format(self._dbUser,
                                                        self._passWrd,
                                                        self._url,
                                                        self._dbName)
        self.Engine = sqlalchemy.create_engine(self._connString, encoding = 'utf-8')
        self._session = sqlalchemy.orm.scoped_session(sqlalchemy.orm.sessionmaker())
        self._session.configure(bind = self.Engine,
                                autoflush = False,
                                expire_on_commit = False)

    def Add(self, what):
        self._session.add(what)
        self._session.flush()
        self._session.commit()
