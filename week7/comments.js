//comment model

class CommentModel {
    // get the initial list of comments out of local storage if it exists
    constructor(type) {
        this.type = type;
        this.comments = readFromLS(this.type) || [];
    }

    // get all comments and apply filter if needed
    getComments(q = null) {
        if (q === null) {
            return this.comments; //no query (filter) get all comments
        } else {
            return this.comments.filter(el => el.post === q); // filtered comments
        }
    }    
    
    //add a new comment
    addComment(postName, userName, commentText) {
        const newComment = {
            post: postName,
            name: userName,
            comment: commentText,
            date: new Date()
        };
        this.comments.push(newComment);
        writeToLS(this.type, this.comments);
    }
}

function writeToLS(key, data) {
    // we can use JSON.stringify to convert our object to a string that can be stored in localStorage.
    window.localStorage.setItem(key, JSON.stringify(data));
}

function readFromLS(key) {
    // the string we retrieve from localStorage needs to be converted back to an object with JSON.parse
    return JSON.parse(window.localStorage.getItem(key));
}


// create the add comment user interface (view)
const commentUI =
    `<div class="addComment">
        <h2>Add a comment</h2>
          <input type="text" id="userName" placeholder="Your name"></br>
          <textarea type="text" cols="50" rows="5" id="commentText" placeholder="Comment"></textarea></br>
          <input type="Submit" id="submitComment" value="Submit">
    </div>
    <h2>Comments</h2>
    <ul class="comments"></ul>`;

// function to view stored comments
function renderCommentList(element, comments) {
    // clear out any comments that might be listed
    element.innerHTML = '';
    // add the new list of comments
    comments.forEach(el => {
        let item = document.createElement('li');
        item.innerHTML = `
              <p class="uName">${el.name}</p> 
              <p class="cText">${el.post}: ${el.comment}</p>
        `;

        element.appendChild(item);
    });
}

// Comments controller

class Comments {
    constructor(type, commentElementId) {
        this.type = type;
        this.commentElementId = commentElementId;
        this.model = new CommentModel(this.type);
    }

    addSubmitListener(postName) {
        document.getElementById('submitComment').onclick = () => {
            // debugger;
            this.model.addComment(
                postName,
                document.getElementById('userName').value,
                document.getElementById('commentText').value
            );
            document.getElementById('userName').value = '';
            document.getElementById('commentText').value = '';
            this.showCommentList(postName);
        };
    }
    showCommentList(q = null) {
        try {
            const parent = document.getElementById(this.commentElementId);
            if (!parent) throw new Error('comment parent not found');
            // check to see if the commentUI code has been added yet
            if (parent.innerHTML === '') {
                parent.innerHTML = commentUI;
            }
            if (q !== null) {
                // looking at one post, show comments and new comment button
                document.querySelector('.addComment').style.display = 'block';
                this.addSubmitListener(q);
            } else {
                // no post name provided, hide comment entry
                document.querySelector('.addComment').style.display = 'none';
            }
            // get the comments from the model
            let comments = this.model.getComments(q);
            if (comments === null) {
                // avoid an error if there are no comments yet.
                comments = [];
            }
            renderCommentList(parent.lastChild, comments);
        } catch (error) {
            console.log(error);
        }
    }
}

export default Comments;