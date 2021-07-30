
/**
 * Task status
 */
const TaskStatus =
{
    NEW: "new",
    WORK: "work",
    COMPLETE: "complete",
};


/**
 * Target
 */
class Target
{
    /**
     * Target id
     */
    id = 0;

    /**
     * Target name
     */
    name = "";
}


/**
 * Task
 */
class Task
{
    /**
     * Task id
     */
    id = 0;

    /**
     * Target id
     */
    target_id = null;

    /**
     * Task name
     */
    name = "";

    /**
     * Task date
     */
    date = null;

    /**
     * Task status
     */
    status = "";

    /**
     * User id
     */
    user_id = null;
}

class TaskList
{
    
}