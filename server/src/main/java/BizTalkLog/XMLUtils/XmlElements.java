package BizTalkLog.XMLUtils;

public enum XmlElements {
    ELEMENT_ROOT {
        @Override
        public String toString() {
            return "company";
        }
    },
    ELEMENT_LOG {
        @Override
        public String toString() {
            return "log";
        }
    },
    ELEMENT_USER_ID {
        @Override
        public String toString() {
            return "userID";
        }
    },
    ELEMENT_LEVEL {
        @Override
        public String toString() {
            return "level";
        }
    },
    ELEMENT_DATE_YEAR {
        @Override
        public String toString() {
            return "year";
        }
    },
    ELEMENT_DATE_MONTH {
        @Override
        public String toString() {
            return "month";
        }
    },
    ELEMENT_DATE_DAY {
        @Override
        public String toString() {
            return "day";
        }
    },
    ELEMENT_DATE_HOUR {
        @Override
        public String toString() {
            return "hrs";
        }
    },
    ELEMENT_DATE_MIN {
        @Override
        public String toString() {
            return "min";
        }
    },
    ELEMENT_DATE_SEC {
        @Override
        public String toString() {
            return "sec";
        }
    },
    ELEMENT_DETAIL {
        @Override
        public String toString() {
            return "detail";
        }
    },
    ELEMENT_ATTR_ID {
        @Override
        public String toString() {
            return "id";
        }
    },
}
